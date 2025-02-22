<?php

namespace App\Services\Product;

use App\Constans\Error;
use App\Exceptions\ResponseException;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\Facades\DB;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts($pagination)
    {
        return $this->productRepository->getAll($pagination);
    }

    public function getProductById($id): ?Product
    {
        return $this->productRepository->findById($id);
    }

    public function createProduct(array $data): Product
    {
        return DB::transaction(fn() => $this->productRepository->create($data));
    }

    public function updateProduct(int $id, array $data): Product
    {
        return DB::transaction(function () use ($id, $data) {
            $product = $this->productRepository->findById($id) ?? throw new ResponseException(Error::CLIENT_ERROR, 'Producto no encontrado.');
            $this->productRepository->update($product, $data);
            return $product->refresh();
        });
    }

    public function increaseProductStock(int $id, int $amount)
    {
        return DB::transaction(function () use ($id, $amount) {
            $product = $this->productRepository->findById($id) ?? throw new ResponseException(Error::CLIENT_ERROR, 'Producto no encontrado.');
            return $this->productRepository->increaseProductStock($product, $amount);
        });
    }

    public function deleteProduct(int $id)
    {
        return DB::transaction(function () use ($id) {
            $product = $this->productRepository->findById($id) ?? throw new ResponseException(Error::CLIENT_ERROR, 'Producto no encontrado.');
            return $this->productRepository->delete($product);
        });
    }
}