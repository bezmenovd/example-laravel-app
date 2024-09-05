<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListRequest;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Query\Builder;

class CatalogController
{
    public function __construct(
        protected CategoryRepository $categoryRepository,
    ) {}    

    public function categories()
    {
        $categoriesTree = $this->categoryRepository->getCategoriesTree();

        return response()->json([
            'tree' => $categoriesTree->toArray(),
        ]);
    }

    public function products(ListRequest $request)
    {
        $products = Product::query()
            ->where('category_id', $request->category_id)
            ->when($request->query, function(Builder $query) use ($request) {
                $query->where('name', 'like', "%{$request->query}%");
            })
            ->limit($request->per_page ?? 10)
            ->offset($request->page ?? 1)
            ->get();
    }
}
