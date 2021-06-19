<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public  function getBrands()
    {
        $brands = Brand::all();
        if (!empty($brands))
        {
            return response()->json(['success'=>true,'response'=> $brands], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
}
