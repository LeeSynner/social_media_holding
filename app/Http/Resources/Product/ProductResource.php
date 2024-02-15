<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ProductResource extends JsonResource
{
    public static $wrap = null;
    protected array $visible = [
        'id',
        'title',
        'description',
        'price',
        'discount_percentage',
        'rating',
        'stock',
        'brand',
        'thumbnail'
    ];

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product = [];

        foreach ($this->visible as $key) {
            if (isset($this[$key])) {
                $product[Str::camel($key)] = $this[$key];
            }
        }

        if(isset($this['category'])) {
            $product['category'] = $this['category']->name;
        }

        if ($this->resource->relationLoaded('images')) {
            $product['images'] = $this['images']->transform(fn($image) => $image->url);
        }

        return $product;
    }
}
