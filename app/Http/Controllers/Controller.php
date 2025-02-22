<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    static function putImg($image, $info)
    {
        $path_put = $info['path_put'] ?? '/storage/';
        $width  = $info['width'] ?? 300;
        $height = $info['height'] ?? null;
        $image_prifix = $info['image_prefix'] ?? null;
        $old_image = $info['old_image'] ?? null;
        $watermark = isset($info['watermark']) ? $info['watermark'] : true;


        // dd($info['watermark']);

        $local_path = $path_put;
        $path = public_path($local_path);

        $image_r = Image::make($image)->encode('webp')->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });

        // $image_r = Image::make($image);

        // if($width != false){
        //   $image_r->resize($width, $height, function ($constraint) {
        //     $constraint->aspectRatio();
        //   });
        // }

        // if($watermark){
        //     // and insert a watermark for example
        //     $image_r->insert(public_path('/images/watermark.png'), 'center');
        // }


        $image_name = $image_prifix.uniqid().time().'.webp';

        // make directory project image if not exits
        if( !File::isDirectory($path) ){
            File::makeDirectory($path, 0777, true, true);
        }
        if(!File::isDirectory($path)) {
            dd('error make directory');
        }

        // // Delete the old image
        if($old_image !== null){
            $file =  public_path($old_image);
            if(File::exists($file)){
                File::delete($file);
            }
        }



        try {
            $image_r->save($path . $image_name);
        }catch(\Exception $e){
            
        }
        
        $db_image = $local_path.$image_name;
        return $db_image;

    }
}
