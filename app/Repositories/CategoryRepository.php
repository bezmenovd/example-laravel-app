<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\CategoryRepository\CategoriesTree;
use Illuminate\Support\Collection;

class CategoryRepository
{
    public function getCategoriesTree(): CategoriesTree
    {
        $categories = Category::query()->get();
        $categoriesMap = [];

        foreach ($categories as $category) {
            /** @var Category $category */
            $categoriesMap[$category->parent_id][] = $category;
        }

        $addChildren = null;
        $addChildren = function(CategoriesTree &$tree) use (&$addChildren, $categoriesMap) 
        {
            $children = key_exists($tree->category?->id, $categoriesMap) ? $categoriesMap[$tree->category?->id] : [];

            foreach ($children as $child) {
                /** @var Category $child */
                $node = new CategoriesTree($child);

                $tree->children[] = $node;
                
                $addChildren($node);
            }
        };

        $tree = new CategoriesTree();

        $addChildren($tree);

        dd($tree);

        return $tree;
    }
}
