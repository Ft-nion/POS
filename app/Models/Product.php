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
        'stock',
        'status',
        'unit',
    ];

    // Casts para tipos de datos
    protected $casts = [
        'sale_price' => 'float',
        'stock' => 'integer',
        'status' => 'boolean',
    ];
}
