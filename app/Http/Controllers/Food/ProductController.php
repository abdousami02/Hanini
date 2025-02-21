<?php

namespace App\Http\Controllers\Food;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('food.product.index');
    }

    public function add()
    {
        return view('food.product.add');
    }
}
