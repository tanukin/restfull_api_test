<?php

namespace App\Core\Product\Repositories;

use App\Core\Product\Dto\ProductDto;
use App\Core\Product\Exceptions\ProductDeleteException;
use App\Core\Product\Exceptions\ProductSaveException;
use App\Core\Product\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    /**
     * @param int $id
     *
     * @return Product|null
     */
    public function getProduct(int $id): ?Product
    {
        return Product::findOrFail($id);
    }

    public function getProducts(ProductDto $dto): Collection
    {
        $builder = Product::on()
            ->limit($dto->getLimit())
            ->offset($dto->getOffset())
            ->orderBy('id');

        return $builder->get();
    }

    /**
     * @param Product $product
     *
     * @return Product
     *
     * @throws ProductSaveException
     */
    public function save(Product $product): Product
    {
        if (!$product->save()) {
            throw new ProductSaveException('Error. Product was not saved');
        }

        return $product;
    }

    /**
     * @param int $id
     *
     * @throws ProductDeleteException
     */
    public function delete(int $id)
    {
        if (!Product::destroy($id)) {
            throw new ProductDeleteException('Error. Product was not deleted');
        }
    }
}