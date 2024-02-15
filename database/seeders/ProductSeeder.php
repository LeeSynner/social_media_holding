<?php

namespace Database\Seeders;

use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProductSeeder extends Seeder
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository) {
        $this->productRepository = $productRepository;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://dummyjson.com/products/search?q=iPhone');

        $json = $response->json();
        $products = $json['products'];
        Log::info('Products', $products);

        foreach ($products as $product) {
            $this->productRepository->create($product);
        }
    }
}
