<?php

namespace App\Core\Product\Services;

use App\Core\Product\Dto\ProductDto;
use App\Core\Product\Exceptions\ProductException;
use App\Core\Product\Models\Product;
use App\Core\Product\Repositories\ProductRepository;
use Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ProductService
{
    /**
     * @var ProductRepository
     */
    private $repository;

    /**
     * ProductService constructor.
     *
     * @param ProductRepository $repository
     */
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     *
     * @return Product
     */
    public function getProduct(int $id): Product
    {
        return $this->repository->getProduct($id);
    }

    /**
     * @param Request $request
     *
     * @return Collection
     */
    public function getProducts(Request $request): Collection
    {
        $dto = new ProductDto();
        $dto->setOffset($request->get('offset'));
        $dto->setLimit($request->get('limit'));

        return $this->repository->getProducts($dto);
    }

    /**
     * @param Request $request
     *
     * @return Product
     *
     * @throws ProductException
     */
    public function create(Request $request): Product
    {
        $product = new Product();
        $product = $this->setProperties($product, $request);
        $product->user_id = Auth::id();

        return $this->repository->save($product);
    }

    /**
     * @param Request $request
     * @param Product $product
     *
     * @return Product
     *
     * @throws ProductException
     */
    public function update(Request $request, Product $product)
    {
        $product = $this->setProperties($product, $request);

        return $this->repository->save($product);
    }

    /**
     * @param int $id
     *
     * @throws ProductException
     */
    public function delete(int $id)
    {
        $this->repository->delete($id);
    }

    /**
     * @param Product $product
     * @param Request $request
     *
     * @return Product
     */
    protected function setProperties(Product $product, Request $request): Product
    {
        $product->name = $request->get('name');
        $product->detail = $request->get('description');
        $product->price = $request->get('price');
        $product->stock = $request->get('stock');
        $product->discount = $request->get('discount');

        return $product;
    }
}