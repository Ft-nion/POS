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
