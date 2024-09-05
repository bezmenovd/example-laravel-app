<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Product;

/**
 * @property string $name
 * @property ?int $parent_id
 * @property Collection<Product> $products
 * @property Category $parent
 * @property Collection<Category> $children
 */
class Category extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
