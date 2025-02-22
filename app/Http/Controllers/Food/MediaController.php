<?php

namespace App\Http\Controllers\Food;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function uploadEditor(Request $request)
    {
        // dd($request->upload);
        if(!$request->hasFile('upload')){
            return response()->json(['upload' => 0]);
          }
      
          $path = $this->putImg($request->upload, [
            'path_put' => '/storage/products-desc/',
            'width'    => '900',
            // 'height'  => '',
            'image_prefix' => '',
            // 'watermark' =>
          ]);
      
          return response()->json([
            // "fileName" => "Screenshot from 2024-04-16 16-02-20.png",
            "uploaded" => 1,
            "url" => url($path),
        ]);
    }
}
