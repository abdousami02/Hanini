<?php

namespace App\Http\Controllers\Food;

use App\Models\Product;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use App\Models\SellerProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\Food\StoreProductRequest;

class ProductController extends Controller
{
    use ImageTrait;

    public function index()
    {
        $products = Product::get();
        return view('food.product.index',compact('products'));
    }

    public function add()
    {
        $sellers = SellerProfile::get();
        return view('food.product.add',compact('sellers'));
    }

    public function store(StoreProductRequest $request)
    {
        $request->flash();
        DB::beginTransaction();
        try{
            if($request->hasFile('image')){
                $media = $this->putImage($request->file('image'), '_image_');
                if(isset($media->original_file) && $media->original_file != ''){
                    $media_id = $media->id;
                }
            }
    
            $product = Product::create([
                'seller_id'     => $request->seller_id,
                'name'          => $request->name,
                'description'   => base64_encode($request->description),
                'image'         => $media_id ?? null,
                'price'         => $request->price,
                'is_active'     => $request->is_active,
                'per_day'       => $request->per_day ?? null,
            ]);

            DB::commit();
            Toastr::success(__('success ajouter plate'));
            return redirect()->route('food.products');

        }catch(\Exception $e){
            DB::rollBack();
            Log::info($e);
            Toastr::error($e->getMessage());
            return back();
        }
        
    }
}
