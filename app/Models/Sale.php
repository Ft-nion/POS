<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\SaleItem;
use App\Models\User;

class Sale extends Model
{
    protected $fillable = [
        'date',
        'total',
        'user_id',
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
}
