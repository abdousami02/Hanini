<?php

namespace App\Http\Controllers\Food;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'count_order' => Order::count(),
            'count_delivred' => Order::where('status', 'delivered')->count(),
            'count_on_delivery' => Order::where('status', 'on_delivery')->count(),
            'count_product' => Product::count(),
        ];
        // $path   = base_path('public/wilayas.json');
        // $states    = file_get_contents($path);

        // dd(json_encode(json_decode($states)));
        return view('food.dashboard', $data);
    }
}
