<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\SaleItem;
use App\Models\User;
use App\Models\CashRegister;

class Sale extends Model
{
    protected $fillable = [
        'date',
        'total',
        'user_id',
        'cash_register_id', // <-- Agrega este campo
    ];

    // Relación: una venta tiene muchos items
    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    // Relación: una venta pertenece a un usuario (vendedor)
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relación: una venta pertenece a una caja
    public function cashRegister()
    {
        return $this->belongsTo(CashRegister::class);
    }
}
