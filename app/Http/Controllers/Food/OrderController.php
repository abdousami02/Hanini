<?php

namespace App\Http\Controllers\Food;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Food\ChangeStatusOrderRequest;
use App\Http\Requests\Food\OrderChangeStatusRequest;
use Brian2694\Toastr\Facades\Toastr;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderDetails.product')->latest()->get();
        return view('food.order.index',compact('orders'));
    }

    public function details($id)
    {
        try{
            $order = Order::findOrFail($id);
            return view('food.order.details', compact('order'));
        }catch(\Exception $e){
            Log::info($e);
            Toastr::error($e->getMessage());
            return back();
        }   
    }

    public function changeStatus(OrderChangeStatusRequest $request)
    {
        DB::beginTransaction();
        try{
            $order = Order::findOrFail($request->id);
            $order->update([
                'status' => $request->status ?? $order->status,
                'payment_status' => $request->payment_status ?? $order->payment_status,
            ]);
            
            DB::commit();
            Toastr::success(__("succès changement statut"));
            return back();

        }catch(\Exception $e){
            DB::rollBack();
            Log::info($e);
            Toastr::error($e->getMessage());
            return back();
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try{
            $order = Order::findOrFail($request->id);
            $order->delete();

            DB::commit();
            return response()->json(['success' =>  __("supprimer avec succès")]);

        }catch(\Exception $e){
            DB::rollBack();
            Log::info($e);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
