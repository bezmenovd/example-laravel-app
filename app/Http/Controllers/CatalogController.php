<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Requests\Catalog\ProductsRequest;
use App\Http\Resources\Catalog\ProductResource;
use App\Models\Product;
use App\Repositories\CategoryRepository;

class CatalogController
{
    public function __construct(
        protected CategoryRepository $categoryRepository,
    ) {}    

    public function categories(Request $request)
    {
        $categoriesTree = $this->categoryRepository->getCategoriesTree();

        return response()->json($categoriesTree->toArray());
    }

    public function products(ProductsRequest $request)
    {
        $products = Product::query()
            ->where('category_id', $request->category_id)
            ->when($request->query, function(Builder $query) use ($request) {
                $query->where('name', 'like', "%{$request->search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(
                perPage: $request->per_page,
                page: $request->page,
            );

        return ProductResource::collection($products);
    }
}
