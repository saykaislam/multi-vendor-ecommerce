<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public  function getSliders()
    {
        $sliders= Slider::all();
        if (!empty($sliders))
        {
            return response()->json(['success'=>true,'response'=> $sliders], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
}
