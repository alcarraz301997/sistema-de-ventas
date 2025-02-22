<?php

namespace App\Services\Sales;

use App\Models\Sales;
use App\Models\Product;
use App\Models\SaleProducts;
use App\Repositories\SalesRepository;
use App\Repositories\ProductRepository;
use App\Constans\Error;
use App\Exceptions\ResponseException;
use App\Exports\SalesReportExport;
use App\Repositories\Product\ProductRepository as ProductProductRepository;
use App\Repositories\Sales\SalesRepository as SalesSalesRepository;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SalesService
{
    protected $salesRepository;
    protected $productRepository;

    public function __construct(SalesSalesRepository $salesRepository, ProductProductRepository $productRepository)
    {
        $this->salesRepository = $salesRepository;
        $this->productRepository = $productRepository;
    }

    public function generateReport($salesReport)
    {
        $sales = $this->salesRepository->getSalesReport($salesReport['start_date'], $salesReport['end_date']);

        if ($salesReport['format'] === 'xlsx') {
            $fileName = 'sales_report_' . now()->format('Ymd_His') . '.xlsx';

            return Excel::download(new SalesReportExport($sales), $fileName);
        }
        return $sales;
    }

    public function createSale(array $data)
    {
        DB::beginTransaction();
        try {
            $saleProducts = $data['products'];
            $totalAmount = 0;

            // Verificar stock y calcular monto total
            foreach ($saleProducts as $productData) {
                $product = $this->productRepository->findById($productData['product_id']);
                if (!$product || $product->stock < $productData['quantity']) {
                    throw new ResponseException(Error::CLIENT_ERROR, 'Stock insuficiente para el producto: ' . $product->name);
                }
                if (!$product->fl_status) throw new ResponseException(Error::CLIENT_ERROR, 'Producto no disponible: ' . $product->name);
                $totalAmount += $product->unit_price * $productData['quantity'];
            }

            // Registrar la venta
            $sale = $this->salesRepository->create(array_merge($data, ['total_amount' => $totalAmount]));

            // Registrar productos y reducir stock
            foreach ($saleProducts as $productData) {
                $product = $this->productRepository->findById($productData['product_id']);
                $this->productRepository->decreaseProductStock($product, $productData['quantity']);

                //Registrar productos
                $productSales = [
                    'product_id' => $product->id,
                    'quantity' => $productData['quantity'],
                    'unit_price' => $product->unit_price,
                    'total_amount' => $product->unit_price * $productData['quantity']
                ];

                $this->salesRepository->addProducts($sale->id, $productSales);
            }

            DB::commit();
            return $sale;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
