<?php

namespace App\Repositories\CategoryRepository;

use App\Models\Category;
use Illuminate\Contracts\Support\Arrayable;

class CategoriesTree implements Arrayable
{
    public function __construct(
        public ?Category $category = null,
        public array $children = [],
    ) {}

    public function toArray()
    {
        return array_merge($this->category?->toArray() ?? [], [
            'children' => array_map(fn(Category $c) => $c->toArray(), $this->children),
        ]);
    }
}
