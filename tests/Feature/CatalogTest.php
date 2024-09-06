<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Resources\Catalog\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Str;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_categories(): void
    {
        Sanctum::actingAs(User::factory()->create());
        
        Category::factory()->count(5)->create();
        Category::factory()->count(10)->create();
        Category::factory()->count(20)->create();

        /** @var CategoryRepository $categoryRepository */
        $categoryRepository = app(CategoryRepository::class);

        $tree = $categoryRepository->getCategoriesTree();

        $response = $this->get(route('catalog.categories'));
        $response->assertJson($tree->toArray());
    }

    public function test_products(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $categories = Category::factory()->count(5)->create();

        foreach ($categories as $category) {
            $products = Product::factory()
                ->count(30)
                ->for($category, 'category')
                ->create();
        }

        $response = $this->get(route('catalog.products', [
            'category_id' => fake()->randomElement($categories->all())->id,
            'page' => $page=random_int(1,3),
            'per_page' => 10,
            'search' => $search=Str::random(1),
        ]));

        $productsBySearch = $products
            ->filter(fn(Product $p) => Str::contains($p->name, $search))
            ->slice(10*($page-1), 10);

        $sorted = $productsBySearch->sortByDesc('id');

        $response->assertJson([
            'data' => ProductResource::collection($sorted)->toArray(new Request()),
        ]);
    }
}
