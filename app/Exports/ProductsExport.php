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
        return Product::select('name', 'barcode', 'description', 'unit', 'sale_price', 'stock', 'status')->get();
    }

    public function headings(): array
    {
        return [
            'nombre',
            'codigo_de_barras',
            'descripcion',
            'unidad',
            'precio_de_venta',
            'stock',
            'estado',
        ];
    }
}
