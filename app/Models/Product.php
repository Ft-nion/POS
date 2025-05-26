<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'name',
        'barcode',
        'purchase_price',
        'sale_price',
        'stock',
        'image',
        'status',
        'unit',
        'is_featured',
    ];

    // Casts para tipos de datos
    protected $casts = [
        'purchase_price' => 'float',
        'sale_price' => 'float',
        'stock' => 'integer',
        'status' => 'boolean',
        'is_featured' => 'boolean',
    ];
}
