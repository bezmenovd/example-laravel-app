<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;

/**
 * @property int $product_id
 * @property Product $product
 * @property int $quantity
 */
class CartItem extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
