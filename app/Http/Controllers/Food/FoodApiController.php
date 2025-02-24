<?php

namespace App\Http\Controllers\Food;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\Food\SendOrderRequest;
use App\Http\Resources\Food\OrderResource;
use App\Http\Resources\Food\ProductResources;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Session;

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
        DB::beginTransaction();
        try{
            $product = Product::findOrFail($request->product_id);

            // session()->put()
            // session()->get()
            // session()->has()
            // session()->forget()

            $total = ($product->price * $request->qte);

            $order = Order::create([
                'seller_id' => $product->seller_id,
                'shipping_address' => [
                    'name' => $request->name,
                    // 'email' => $request->email,
                    'phone_no' => $request->mobile,
                    'address' => $request->address,
                    // "country"   => "Algeria",
                    "state"     => "Chlef",
                    // "city"      => "Chettia",
                    // "address_ids" => [
                    //     "country_id"=> "4",
                    //     "state_id"  => "2",
                    //     "city_id"   => "1"
                    // ],
                    // "latitude"  => "",
                    // "longitude" => "",
                    // "postal_code" => "",
                ],
                'status' => 'on_process',
                'payment_type' => 'cash_on_delivery',
                'payment_status' => 'unpaid',   // unpaid|paid
                'sub_total' => $total,
                'total_amount' => $total,
                'shipping_cost' => 0,
                'total_payable' => $total,
                'date' => now(),
            ]);

            $order_details = OrderDetail::create([
                'order_id'          => $order->id,
                'product_id'        => $product->id,
                'price'             => $product->price,
                // 'tax'               => $item->tax,
                // 'discount'          => $item->discount,
                // 'coupon_discount'   => $coupon,
                'qte'          => $request->qte,
            ]);

            if(session()->has('user_orders')){
                $old_orders = session()->get('user_orders');
                array_push($old_orders, $order->id);
                session()->put('user_orders', $old_orders);

            }else{
                session()->put('user_orders',[$order->id]);
            }
            
            DB::commit();
            return response()->json(['success' => 'success store order', 'all_order' => session()->get('user_orders')]);
        }catch(\Exception $e){
            DB::rollBack();
            Log::info($e);
            return response()->json(['error' => $e->getMessage()]);
        } 
    }

    public function getAllOrder()
    {
        try{

            $orders_ids = session()->get('user_orders');
            if($orders_ids){
                $orders = Order::whereIn('id', $orders_ids)->with('orderDetails.product')->get();

            }else{
                $orders = [];
            }
            return response()->json(['success' => OrderResource::collection($orders)]);

        }catch(\Exception $e){
            DB::rollBack();
            Log::info($e);
            return response()->json(['error' => $e->getMessage()]);
        } 
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
