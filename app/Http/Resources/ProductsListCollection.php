<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductsListCollection extends ResourceCollection
{
    public function toArray($request)
    {
        //return 'products collections';
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => $data->id,
                    'name' => $data->name,
                    'thumbnail_image' => $data->thumbnail_img,
                    'base_price' => (double) $data->unit_price,
                    'base_discounted_price' => (double) home_discounted_base_price($data->id),
                    'discount' => (double) $data->discount,
                    'discount_type' => $data->discount_type,
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
