<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Offer;
use App\Model\Order;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function getOffers() {
        $offers = Offer::all();
        if (!empty($offers))
        {
            return response()->json(['success'=>true,'response'=> $offers], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
}
