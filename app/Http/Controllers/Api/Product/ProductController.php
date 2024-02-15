<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\CategoryCollection;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Interfaces\Repositories\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private const TITLE = 'title';
    private const DESCRIPTION = 'description';
    private const PRICE = 'price';
    private const DISCOUNT_PERCENTAGE = 'discountPercentage';
    private const RATING = 'rating';
    private const STOCK = 'stock';
    private const BRAND = 'brand';
    private const CATEGORY = 'category';
    private const THUMBNAIL = 'thumbnail';
    private const IMAGES = 'images';

    private ProductRepositoryInterface $productRepository;
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'limit' => 'nullable|integer',
            'offset' => 'nullable|integer',
            'select' => 'nullable|string'
        ]);

        if ($validator->failed()) {
            return response([], 422);
        }

        $limit = $request->input('limit', 30);
        $offset = $request->input('offset', 0);
        $selectString = $request->input('select');
        $select = !empty($selectString) ? explode(',', $selectString) : [];

        $products = $this->productRepository->getAll($limit, $offset, $select);

        return new ProductCollection($products);
    }

    public function categories() {
        return new CategoryCollection($this->productRepository->getProductCategories());
    }

    public function productsByCategory($id) {
        return new ProductCollection($this->productRepository->getByCategory($id));
    }

    public function search(Request $request) {
        $q = $request->input('q', '');
        return new ProductCollection($this->productRepository->search($q));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            self::TITLE => 'required|max:255',
            self::DESCRIPTION => 'required',
            self::PRICE => 'required|double',
            self::DISCOUNT_PERCENTAGE => 'required|double',
            self::RATING => 'required|double',
            self::STOCK => 'required|integer',
            self::BRAND => 'required|string|max:255',
            self::CATEGORY => 'required|max:255',
            self::THUMBNAIL => 'required|url',
            self::IMAGES => 'nullable|array',
        ]);

        if ($validator->failed()) {
            return response()->json([
                'errorMessage' => $validator->messages()
            ], 422);
        }

        $data = $validator->validated();
        $product = $this->productRepository->create($data);
        return response()->json(new ProductResource($product), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->productRepository->getById($id);
        if (is_null($product)) {
            return response('', 404);
        }
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // TODO: update
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // TODO: delete
//        $product = $this->productRepository->getById($id);
//
//        $deleted = is_null($product);
//
//        if (!$deleted) {
//            $delete = $this->productRepository->delete($id);
//        }
//
//        if (!$deleted) {
//            return response([], 500);
//        }
//
//        return new ProductResource($product);
    }
}
