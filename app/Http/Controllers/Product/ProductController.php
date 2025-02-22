<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\Product\ProductAmountRequest;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Product;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(PaginateRequest $request)
    {
        $products = $this->productService->getAllProducts($request);
        return $this->response($products, 'OK');
    }

    public function show($id)
    {
        $product = $this->productService->getProductById($id);
        return $this->response($product, 'OK');
    }

    public function store(ProductRequest $request)
    {
        $product = $this->productService->createProduct($request->all());
        return $this->response($product, 'Producto creado');
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        $product = $this->productService->updateProduct($id, $request->all());
        return $this->response($product, 'Producto actualizado');
    }

    public function increaseStock(ProductAmountRequest $request, $id)
    {
        $updatedProduct = $this->productService->increaseProductStock($id, $request->amount);
        return $this->response($updatedProduct, 'Stock actualizado');
    }

    public function delete($id)
    {
        $this->productService->deleteProduct($id);
        return $this->response([], 'Producto eliminado');
    }
}
