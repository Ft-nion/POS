<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Selecciona solo los campos que quieres exportar
        return Product::select('id', 'name', 'barcode', 'description', 'unit', 'sale_price', 'stock', 'status')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Código de barras',
            'Descripción',
            'Unidad',
            'Precio de venta',
            'Stock',
            'Estado',
        ];
    }
}
