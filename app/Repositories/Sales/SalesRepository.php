<?php

namespace App\Repositories\Sales;

use App\Models\SaleProducts;
use App\Models\Sales;
use Illuminate\Support\Facades\Auth;

class SalesRepository
{
    public function getSalesReport($startDate, $endDate)
    {
        return Sales::with('saleProducts')
            ->whereBetween('sale_date', [$startDate, $endDate])
            ->where('fl_status', true)
            ->get()
            ->map(function ($sale) {
                return [
                    'code'               => $sale->code,
                    'customer_name'      => $sale->customer_name,
                    'customer_id'        => $sale->customer_id_type . ' ' . $sale->customer_id_number,
                    'customer_email'     => $sale->customer_email,
                    'total_products'     => $sale->total_products,
                    'total_amount'       => $sale->total_amount,
                    'sale_date'          => $sale->sale_date,
                ];
            });
    }

    public function create(array $data): Sales
    {
        return Sales::create([
            'code' => $data['code'],
            'customer_name' => $data['customer_name'],
            'customer_id_type' => $data['customer_id_type'],
            'customer_id_number' => $data['customer_id_number'],
            'customer_email' => $data['customer_email'],
            'user_id' => Auth::user()->id,
            'total_amount' => $data['total_amount'],
            'sale_date' => $data['sale_date'],
        ]);
    }

    public function addProducts(int $saleId, array $product): void
    {
        SaleProducts::create([
            'sale_id' => $saleId,
            'product_id' => $product['product_id'],
            'quantity' => $product['quantity'],
            'unit_price' => $product['unit_price'],
            'total_amount' => $product['total_amount']
        ]);
    }

    public function findById(int $id): ?Sales
    {
        return Sales::with('saleProducts')->find($id);
    }

    public function delete(Sales $sale): bool
    {
        $sale->saleProducts->each(function ($item) {
            $item->delete();
        });
        return $sale->update(['fl_status' => false]);
    }
}