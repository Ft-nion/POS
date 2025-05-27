<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = \App\Models\Product::count();

        return inertia('Dashboard', [
            'totalProducts' => $totalProducts,
        ]);
    }
}
