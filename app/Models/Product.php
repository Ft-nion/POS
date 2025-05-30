<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'name',
        'barcode',
        'description', // Agregado
        'sale_price',
        'purchase_price', // Agregado
        'stock',
        'status',
        'unit',
    ];

    // Casts para tipos de datos
    protected $casts = [
        'sale_price' => 'float',
        'purchase_price' => 'float', // Agregado
        'stock' => 'integer',
        'status' => 'boolean',
    ];
}
