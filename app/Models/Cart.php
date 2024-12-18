<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\CartItem;

class Cart extends Model
{
    use HasFactory;

    protected $fillable=[
      'storage_id',
      'user_id'
    ];

    public function cartItems(): HasMany
    {
      return $this->hasMany(CartItem::class);
    }
}
