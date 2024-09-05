<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\CategoryRepository\CategoriesTree;
use Illuminate\Support\Collection;

class CategoryRepository
{
    public function getCategoriesTree(): CategoriesTree
    {
        function addChildren(CategoriesTree &$tree, Collection &$categories) {
            $children = $categories->filter(fn(Category $c) => $c->parent_id == $tree->category?->id ?? null);
            
            foreach ($children as $child) {
                /** @var Category $child */
                $node = new CategoriesTree($child);
                $tree->children[] = $node;
                addChildren($node, $categories);
            }
        };

        $categories = Category::query()->get();
        $tree = new CategoriesTree();

        addChildren($tree, $categories);

        return $tree;
    }
}
