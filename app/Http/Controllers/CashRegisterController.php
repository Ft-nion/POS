<?php

namespace App\Http\Controllers;

use App\Models\CashRegister;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CashRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cashRegisters = CashRegister::with('user')->orderBy('opened_at', 'desc')->get();
        return inertia::render('cash_registers/index', [
            'cashRegisters' => $cashRegisters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia::render('cash_registers/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verifica si ya hay una caja abierta para este usuario
        $cajaAbierta = CashRegister::where('user_id', auth()->id())
            ->whereNull('closed_at')
            ->first();

        if ($cajaAbierta) {
            return redirect()->back()->with('error', 'Ya tienes una caja abierta. Debes cerrarla antes de abrir una nueva.');
        }

        $validated = $request->validate([
            'opening_amount' => 'required|numeric|min:0',
        ]);

        CashRegister::create([
            'user_id' => auth()->id(),
            'opening_amount' => $validated['opening_amount'],
            'opened_at' => now(),
        ]);

        return redirect()->route('cash_registers.index')->with('success', 'Caja abierta correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CashRegister $cashRegister)
    {
        return inertia::render('cash_registers/show', [
            'cashRegister' => $cashRegister->load('user', 'sales'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CashRegister $cashRegister)
    {
        return inertia::render('cash_registers/edit', [
            'cashRegister' => $cashRegister,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CashRegister $cashRegister)
    {
        // Suma de ventas asociadas a la caja
        $ventas = $cashRegister->sales()->sum('total');
        $closing_amount = $cashRegister->opening_amount + $ventas;

        $cashRegister->update([
            'closing_amount' => $closing_amount,
            'closed_at' => now(),
        ]);

        return redirect()->route('cash_registers.index')->with('success', 'Caja cerrada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
