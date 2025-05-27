<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::with('user')->latest()->get();
        return Inertia::render('purchases/index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where('status', true)->get();
        return Inertia::render('purchases/create', compact('products'));
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
            'items.*.purchase_price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|numeric|min:1',
        ]);

        $total = collect($validated['items'])->reduce(function ($carry, $item) {
            return $carry + ($item['quantity'] * $item['purchase_price']);
        }, 0);

        $purchase = Purchase::create([
            'user_id' => auth()->id(),
            'date' => $validated['date'],
            'total' => $total,
        ]);

        foreach ($validated['items'] as $item) {
            $purchase->details()->create([
                'product_id' => $item['product_id'],
                'purchase_price' => $item['purchase_price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['quantity'] * $item['purchase_price'],
            ]);

            // Sumar la cantidad al stock del producto
            $product = \App\Models\Product::find($item['product_id']);
            if ($product) {
                $product->stock += $item['quantity'];
                $product->save();
            }
        }

        return redirect()->route('purchases.index')->with('success', 'Compra registrada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        $purchase->load(['details.product', 'user']);
        return Inertia::render('purchases/show', compact('purchase'));
    }
}
