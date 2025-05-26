<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Sale;
use App\Models\Product;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'price',
        'subtotal',
    ];

    // Relación: un item pertenece a una venta
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    // Relación: un item pertenece a un producto
    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
