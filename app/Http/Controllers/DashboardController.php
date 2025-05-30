<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CashRegister;
use App\Models\Sale;
use Inertia\Inertia;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Total de productos
        $totalProducts = Product::count();

        // Cajas abiertas/cerradas
        $openRegisters = CashRegister::whereNull('closed_at')->count();
        $closedRegisters = CashRegister::whereNotNull('closed_at')->count();

        // Dinero en caja activa (puedes ajustar según tu lógica)
        $cashRegisterAmount = CashRegister::where('user_id', $user->id)
            ->whereNull('closed_at')
            ->sum('opening_amount');

        // Ventas del día
        if ($user->role === 'admin') {
            $todaySales = Sale::whereDate('date', now()->toDateString())->sum('total');
        } else {
            // Solo ventas del usuario y de sus cajas abiertas hoy
            $todaySales = Sale::where('user_id', $user->id)
                ->whereDate('date', now()->toDateString())
                ->sum('total');
        }

        return Inertia::render('Dashboard', [
            'totalProducts' => $totalProducts,
            'cashRegisterAmount' => $cashRegisterAmount,
            'todaySales' => $todaySales,
            'openRegisters' => $openRegisters,
            'closedRegisters' => $closedRegisters,
        ]);
    }
}
