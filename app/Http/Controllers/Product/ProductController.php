<?php

namespace App\Http\Controllers\Product;

use App\Core\Product\Exceptions\ProductException;
use App\Core\Product\Exceptions\ProductNotBelongsToUser;
use App\Core\Product\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Core\Product\Models\Product;
use Auth;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * @var ProductService
     */
    private $service;

    /**
     * @param ProductService $service
     */
    public function __construct(ProductService $service)
    {
        $this->middleware('auth:api')->except('index', 'show');
        $this->service = $service;
    }

    /**
     * @param PaginationRequest $request
     *
     * @return Response
     */
    public function index(PaginationRequest $request)
    {
        $products = $this->service->getProducts($request);

        $collection = ProductCollection::collection($products);

        return response()->json($collection, Response::HTTP_OK);
    }

    /**
     * @param ProductRequest $request
     *
     * @return Response
     *
     * @throws ProductException
     */
    public function store(ProductRequest $request)
    {
        $product = $this->service->create($request);

        return response([
            'data' => new ProductResource($product)
        ], Response::HTTP_CREATED);
    }

    /**
     * @param  int $id
     *
     * @return ProductResource
     */
    public function show(int $id)
    {
        $product = $this->service->getProduct($id);

        return new ProductResource($product);
    }

    /**
     * @param  ProductRequest $request
     * @param  int $id
     *
     * @return Response
     *
     * @throws ProductException
     */
    public function update(ProductRequest $request, int $id)
    {
        $product = $this->service->getProduct($id);
        $this->productUserCheck($product);

        $product = $this->service->update($request, $product);

        return response([
            'data' => new ProductResource($product)
        ], Response::HTTP_OK);
    }

    /**
     * @param int $id
     *
     * @return Response
     *
     * @throws ProductException
     */
    public function destroy(int $id)
    {
        $this->service->delete($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @param Product $product
     *
     * @throws ProductNotBelongsToUser
     */
    protected function productUserCheck(Product $product)
    {
        if (Auth::id() !== $product->user_id) {
            throw new ProductNotBelongsToUser('Product not belongs to user');
        }
    }
}
