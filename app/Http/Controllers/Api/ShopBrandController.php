<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\ShopBrand;
use Illuminate\Http\Request;

class ShopBrandController extends Controller
{
    public  function getShopBrands() {
        $shopBrands= ShopBrand::all();
        if (!empty($shopBrands))
        {
            return response()->json(['success'=>true,'response'=> $shopBrands], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
}
