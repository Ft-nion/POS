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
        $totalProducts = Product::count();

        // Caja activa del usuario
        $cashRegister = CashRegister::where('user_id', auth()->id())
            ->whereNull('closed_at')
            ->latest('opened_at')
            ->first();

        $cashRegisterAmount = $cashRegister
            ? $cashRegister->opening_amount + $cashRegister->sales()->sum('total')
            : 0;

        // Ventas del día
        $todaySales = Sale::whereDate('created_at', Carbon::today())->sum('total');

        // Cajas abiertas/cerradas
        $openRegisters = CashRegister::whereNull('closed_at')->count();
        $closedRegisters = CashRegister::whereNotNull('closed_at')->count();

        return inertia('Dashboard', [
            'totalProducts'      => $totalProducts,
            'cashRegisterAmount' => $cashRegisterAmount,
            'todaySales'         => $todaySales,
            'openRegisters'      => $openRegisters,
            'closedRegisters'    => $closedRegisters,
        ]);
    }
}
