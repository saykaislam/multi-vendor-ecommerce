<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Product::where('added_by','seller')->latest()->get();
    }

    public function headings(): array
    {
        return [
            'product_name',
            'seller_name',
            'shop_name',
            'user_id',
            'category_id',
            'subcategory_id',
            'subsubcategory_id',
            'brand_id',
            'video_link',
            'unit_price',
            'purchase_price',
            'unit',
            'current_stock',
            'num_of_sale',
            'unit',
            'discount',
            'vat',
            'labour_cost',

        ];
    }
    public function map($product): array
    {
        return [
            $product->name,
            $product->user->name,
            $product->user->shop->name,
            $product->user_id,
            $product->category_id,
            $product->subcategory_id,
            $product->subsubcategory_id,
            $product->brand_id,
            $product->video_link,
            $product->unit_price,
            $product->purchase_price,
            $product->unit,
            $product->current_stock,
            $product->num_of_sale,
            $product->unit,
            $product->discount,
            $product->vat,
            $product->labour_cost,
        ];
    }

}
