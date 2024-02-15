<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    public static $wrap = null;
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $products = $this->collection->transform(function ($product) {
            return new ProductResource($product);
        });

        return [
            'products' => $products,
            'total' => $this->collection->count()
        ];
    }
}
