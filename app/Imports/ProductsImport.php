<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {        
                // Verifica si ya existe un producto con el mismo nombre o código de barras
        $exists = Product::where('name', $row['nombre'])
            ->orWhere(function($q) use ($row) {
                if (!empty($row['codigo_de_barras'])) {
                    $q->where('barcode', $row['codigo_de_barras']);
                }
            })
            ->orWhere(function($q) use ($row) {
                if (!empty($row['codigo_de_barras'])) {
                    $q->where('barcode', $row['codigo_de_barras']);
                }
            })
            ->exists();

        if ($exists) {
            // Si existe, no lo importa (retorna null)
            return null;
        }

        return new Product([
            'name'        => $row['nombre'],
            'barcode'     => $row['codigo_de_barras'],
            'description' => $row['descripcion'],
            'unit'        => $row['unidad'],
            'sale_price'  => $row['precio_de_venta'],
            'stock'       => $row['stock'],
            'status'      => $row['estado'],
        ]);
    }
}
