<?php

namespace App\Http\Controllers\Food;

use App\Models\Product;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use App\Models\SellerProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Food\ProductChangeStatusRequest;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\Food\StoreProductRequest;
use App\Http\Requests\Food\UpdateProductRequest;
use PhpParser\Node\Expr\FuncCall;

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

    public function edit($id, Request $request)
    {
        try{
            $sellers = SellerProfile::get();
            $product = Product::findOrFail($id);
            return view('food.product.edit',compact('sellers', 'product'));

        }catch(\Exception $e){
            DB::rollBack();
            Log::info($e);
            Toastr::error($e->getMessage());
            return back();
        }
        
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
                'is_active'     => $request->is_active ?? 0,
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

    public function update($id, UpdateProductRequest $request)
    {
        $request->flash();
        DB::beginTransaction();
        try{
            $product = Product::findOrFail($id);

            if($request->hasFile('image')){
                $media = $this->putImage($request->file('image'), '_image_');
                if(isset($media->original_file) && $media->original_file != ''){
                    $media_id = $media->id;
                }
            }else{
                $media_id = $product->image;
            }
    
            $product->update([
                'seller_id'     => $request->seller_id,
                'name'          => $request->name,
                'description'   => base64_encode($request->description),
                'image'         => $media_id ?? null,
                'price'         => $request->price,
                // 'is_active'     => $request->is_active,
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

    public function changeStatus(ProductChangeStatusRequest $request)
    {
        DB::beginTransaction();
        try{
            // dd($request);
            $product = Product::findOrFail($request->id);
            if($request->change_for == 'ofday' && $request->status == 1){
                $other = Product::where('id', '!=', $product->id)->get();
                foreach($other ?? [] as $elem){
                    // dd($elem);
                    $elem->update([
                        'is_active' => 0,
                    ]);
                }
                $product->update([
                    'is_active' => $request->status,
                ]);
                DB::commit();
                return response()->json(['success' => __("change statut avec succès")]);
            }
            DB::commit();
            return response()->json(['success' => __("not change")]);


        }catch(\Exception $e){
            DB::rollBack();
            Log::info($e);
            Toastr::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try{
            $product = Product::findOrFail($request->id);
            $product->delete();

            DB::commit();
            return response()->json(['success' =>  __("supprimer avec succès")]);

        }catch(\Exception $e){
            DB::rollBack();
            Log::info($e);
            Toastr::error($e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
