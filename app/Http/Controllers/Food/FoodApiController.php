<?php

namespace App\Http\Controllers\Food;

use App\Http\Controllers\Controller;
use App\Http\Requests\Food\SendOrderRequest;
use App\Http\Resources\Food\ProductResources;
use Illuminate\Http\Request;

class FoodApiController extends Controller
{
    public function getMenu()
    {
        $desc = '<p style="text-align: left;"><strong>طبق اليوم بوراك محشي:</strong></p>
        <p style="text-align: left;"><strong>المكونات:&nbsp;</strong></p>
        <p style="text-align: left;">بطاط</p>';

        $product = [
            'id' => 44,
            'image' => urlencode(url('/storage/images/borak.jpg')),
            'name' => 'طبق البوراك',
            'description' => base64_encode($desc),
        ];
        return response()->json(['success' => $product]);
    }

    public function sendOrder(SendOrderRequest $request)
    {
        return response()->json(['success' => 'success store order']);
    }
}
