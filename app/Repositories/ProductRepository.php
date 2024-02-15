<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll($limit = 30, $skip = 0, $select = [])
    {
        $query = Product::query();

        if (!empty($select) && !in_array('images', $select)) {
            $query->withOnly(['category']);
        }

        if (in_array('category', $select)) {
            $select[] = 'category_id';
        }

        if (in_array('discountPercentage', $select)) {
            $select[] = 'discount_percentage';
        }

        $columns = Schema::getColumnListing('products');
        $select = array_intersect($select,  $columns);
        if (count($select) > 0) {
            if (!in_array('id', $select)) {
                $select[] = 'id';
            }
            $query->select($select);
        }
        $query->limit($limit)->skip($skip);
        return $query->get();
    }

    public function getById($id): Product|null
    {
        return Product::find($id);
    }

    public function search($q)
    {
        return Product::where('title', 'like', '%' . $q . '%')
            ->orWhere('description', 'like', '%' . $q . '%')
            ->get();
    }

    public function getByCategory($id)
    {
        return Product::where('category_id', $id)->get();
    }

    public function getProductCategories()
    {
        return Category::all();
    }

    public function create($data)
    {
        Log::info('Product will be created', $data);
        try {
            DB::beginTransaction();
            $category = Category::where('name', $data['category'])->first();
            if (is_null($category)) {
                $category = Category::create([
                    'name' => $data['category'],
                ]);
            }
            $productData = [
                'title' => $data['title'],
                'description' => $data['description'],
                'price' => $data['price'],
                'discount_percentage' => $data['discountPercentage'],
                'rating' => $data['rating'],
                'stock' => $data['stock'],
                'brand' => $data['brand'],
                'category_id' => $category->id,
                'thumbnail' => $data['thumbnail']
            ];
            $product = Product::create($productData);

            $images = $data['images'] ?? [];
            foreach ($images as $image) {
                Image::create([
                    'url' => $image,
                    'product_id' => $product->id,
                ]);
            }
            DB::commit();
            Log::info('Product was created', $productData);
        } catch (\Throwable) {
            DB::rollback();
        }
    }

    public function update($id, $data)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        return Product::find($id)->delete();
    }
}
