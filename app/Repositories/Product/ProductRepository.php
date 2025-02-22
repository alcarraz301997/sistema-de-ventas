<?php

namespace App\Repositories\Product;

use App\Models\Product;

class ProductRepository
{
    public function getAll($pagination)
    {
        return Product::paginate($pagination->per_page, ['*'], 'page', $pagination->page);
    }

    public function findById($id)
    {
        return Product::find($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data)
    {
        $product->update($data);
        return $product;
    }

    public function increaseProductStock(Product $product, int $amount)
    {
        $product->stock += $amount;
        $product->save();

        return $product;
    }

    public function decreaseProductStock(Product $product, int $amount)
    {
        $product->stock -= $amount;
        $product->save();

        return $product;
    }

    public function delete(Product $product)
    {
        $product->update(['fl_status' => false]);
    }
}