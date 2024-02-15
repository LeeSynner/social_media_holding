<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://dummyjson.com/products/categories');
        $categories = $response->json();
        Log::info($categories);

        foreach ($categories as $category) {
            $data = [
                'name' => $category
            ];
            Log::info('Category will be created', $data);
            Category::create($data);
            Log::info('Category was created', $data);
        }
    }
}
