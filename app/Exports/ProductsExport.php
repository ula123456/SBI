<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Загружаем все товары с категорией
        return Product::with('category')->get()->map(function ($product) {
            return [
                'name'        => $product->name,
                'barcode'     => $product->barcode,
                'price'       => $product->price,
                'category'    => optional($product->category)->name,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Название товара',
            'Штрихкод',
            'Цена',
            'Категория',
        ];
    }
}