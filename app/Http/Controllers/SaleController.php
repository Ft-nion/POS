<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia::render('sales/index', [
            'sales' => Sale::with(['user', 'items.product'])
                ->orderBy('created_at', 'desc')
                ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();

        return inertia::render('sales/create', [
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        // Calcula el total en el backend
        $total = collect($validated['items'])->reduce(function ($carry, $item) {
            return $carry + ($item['quantity'] * $item['price']);
        }, 0);

        // Buscar la caja activa del usuario
        $cashRegister = \App\Models\CashRegister::where('user_id', auth()->id())
            ->whereNull('closed_at')
            ->latest('opened_at')
            ->first();

        if (!$cashRegister) {
            return redirect()->back()->with('error', 'No tienes una caja abierta.');
        }

        $sale = Sale::create([
            'user_id' => auth()->id(),
            'date' => $validated['date'],
            'total' => $total,
            'cash_register_id' => $cashRegister->id,
        ]);

        foreach ($validated['items'] as $item) {
            $sale->items()->create([
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
                'subtotal'   => $item['quantity'] * $item['price'],
            ]);
        }

        return redirect()->route('sales.index')->with('success', 'Venta registrada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        $sale->load(['items.product', 'user']);
        return inertia('sales/show', ['sale' => $sale]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
