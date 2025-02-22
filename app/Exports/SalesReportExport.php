<?php

namespace App\Exports;

use App\Models\Sales;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesReportExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'Código',
            'Nombre cliente',
            'Identificación cliente',
            'Correo cliente',
            'Cantidad productos',
            'Monto total',
            'Fecha y hora',
        ];
    }

    public function map($sale): array
    {
        return [
            $sale->code,
            $sale->customer_name,
            "{$sale->customer_id_type} {$sale->customer_id_number}",
            $sale->customer_email ?? 'N/A',
            $sale->saleProducts->sum('quantity'),
            number_format($sale->total_amount, 2),
            $sale->sale_date->format('Y-m-d H:i'),
        ];
    }
}
