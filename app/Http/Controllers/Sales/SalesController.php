<?php

namespace App\Http\Controllers\Sales;

use App\Exports\SalesReportExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sales\SalesReport;
use App\Http\Requests\Sales\SalesRequest;
use App\Models\Sales;
use App\Services\Sales\SalesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SalesController extends Controller
{
    protected $saleService;

    public function __construct(SalesService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function report(SalesReport $request)
    {
        $this->authorize('report', Sales::class);
        $sales = $this->saleService->generateReport($request->all());
        if ($request->input('format') == 'xlsx') return $sales;
        return $this->response($sales, 'OK.');
    }

    public function store(SalesRequest $request)
    {
        $this->authorize('store', Sales::class);
        $sale = $this->saleService->createSale($request->validated());
        return $this->response($sale, 'Venta registrada correctamente.');
    }
}
