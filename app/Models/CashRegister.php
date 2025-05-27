<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashRegister extends Model
{
    protected $fillable = [
        'user_id',
        'opening_amount',
        'closing_amount',
        'opened_at',
        'closed_at',
    ];

    // Relación con el usuario que abrió la caja
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con ventas asociadas a la caja
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
