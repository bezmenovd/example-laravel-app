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

    public function toArray(callable $format = null)
    {
        return array_merge(($format ? $format($this->category) : $this->category?->toArray()) ?? [], [
            'children' => array_map(fn(CategoriesTree $ct) => $format ? $format($ct) : $ct->toArray(), $this->children),
        ]);
    }
}
