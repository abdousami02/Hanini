<?php

namespace App\Http\Controllers\Food;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Food\SendOrderRequest;
use App\Http\Resources\Food\ProductResources;

class FoodApiController extends Controller
{
    public function getMenu()
    {
        try{
            $product = Product::where('is_active', 1)->first();
            return response()->json(['success' => new ProductResources($product)]);

        }catch(\Exception $e){
            Log::info($e);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
        // $desc = '<p style="text-align: left;"><strong>طبق اليوم بوراك محشي:</strong></p>
        // <p style="text-align: left;"><strong>المكونات:&nbsp;</strong></p>
        // <p style="text-align: left;">بطاط</p>';

        // $product = [
        //     'id' => 44,
        //     'image' => urlencode(url('/storage/images/borak.jpg')),
        //     'name' => 'طبق البوراك',
        //     "price"=> 1234,
        //     "currency"=> "DA",
        //     'description' => base64_encode($desc),
        // ];
        // return response()->json(['success' => $product]);
    }

    public function sendOrder(SendOrderRequest $request)
    {
        
        return response()->json(['success' => 'success store order']);
    }

    public function getAllOrder()
    {
        $data = [
            [
                'id' => 3,
                'image' => urlencode(url('/storage/images/borak.jpg')),
                'name' => 'Plate bourak',
                'date' => '2025-02-23T11:33:51Z',
                'status' => 'on_process',
                'status_text' => 'en coure',
                'price' => '1254',
                'currency' => 'DA',
            ],
            [
                'id' => 3,
                'image' => urlencode(url('/storage/images/borak.jpg')),
                'name' => 'Plate methoem',
                'date' => '2025-02-23T11:33:51Z',
                'status' => 'on_delivery',
                'status_text' => 'en livraison',
                'price' => '1254',
                'currency' => 'DA',
            ]
        ];
        return response()->json(['success' => $data]);
    }

    public function getState()
    {
        $data = [
            [
                'number' => 35,
                'name' => 'boumerdes',
            ],
            [
                'number' => 16,
                'name' => 'alger'
            ]
            ];
        return response()->json(['success' => $data]);
    }
}
