<?php

namespace App\Traits;

use App\Models\Media;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;
use Intervention\Image\Drivers\Imagick\Driver;
// use Intervention\Image\Drivers\Gd\Driver;

trait ImageTrait {

    public function putImage($image, $info)
    {
        $path_put = '/storage/images/';
        $width  = 900;
        $image_prifix = 'product_';
        // $height = $info['height'] ?? null;
        // $old_image = $info['old_image'] ?? null;
        // $watermark = isset($info['watermark']) ? $info['watermark'] : true;

        $name_arr = explode('.', $image->getClientOriginalName());
        array_pop($name_arr);
        $name = join('.',$name_arr);
        if(strlen($name) > 100){
            throw  new \Exception(__('Name of image too long'));
        }

        // dd($info['watermark']);

        $local_path = $path_put;
        $path = public_path($local_path);

        $image_r = Image::make($image)->encode('webp')->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $image_name = $image_prifix.uniqid().time().'.webp';

        // make directory project image if not exits

        File::ensureDirectoryExists($path, 0755, true);

        if(!File::isDirectory($path)) {
            dd('error make directory');
        }

        // Delete the old image
        // if($old_image !== null){
        //     $file =  public_path($old_image);
        //     if(File::exists($file)){
        //         File::delete($file);
        //     }
        // }

        try {
            $image_r->save($path . $image_name);
        }catch(\Exception $e){
            
        }
        
        $db_image = $local_path.$image_name;

        $size = File::size($path . $image_name);
        $user_id = auth()->user()->id;
        
        $media = Media::create([
            'name'      => $name,
            'user_id'   => $user_id,
            'type'      => 'image',
            'extension' => 'webp',
            'size'      => $size,
            'original_file'  => $image_name,
            'image_variants' => []
        ]);
        // dd(mime_content_type($path . $image_name));
        return $media;   
    }


    public function saveImage($image, $for='_image_', $nameImage=null)
    {
        // check if jpeg format is supported by file extension
        $driver = new Driver();
        $result = $driver->supports($image->getMimeType());
        if(!$result){
            throw  new \Exception(__('This image not supported'));
        }

        if($nameImage){
            $name = $nameImage;

        }else{
            $name_arr = explode('.', $image->getClientOriginalName());
            array_pop($name_arr);
            $name = join('.',$name_arr);
            if(strlen($name) > 100){
                throw  new \Exception(__('Name of image too long'));
            }
        }

        // $manager = new ImageManager(new Driver());
        // $manager =  $manager->read($image);

        $manager =  ImageManager::imagick()->read($image);
        
        if($for == '_media_'){
            // $image_prifix = 'media';
            $local_path = '/storage/media/';

        }else{
            $manager->scale(width: 900);
            // $image_prifix = 'project';
            $local_path = '/storage/images/';

            // if($watermark){
            //     // and insert a watermark for example
            //     $manager->place(public_path('/images/watermark.png'), 'center');
            // }
        }
        // thumbnail


        $manager->toWebp(80);
        $extension = 'webp';

        $directory = public_path($local_path);

        $image_name = date('YmdHis').'_origin_'.'_'.uniqid().'.'.$extension;

        // make directory project image if not exits
        // if( !File::isDirectory($directory) ){
        //     File::makeDirectory($directory, 0755, true, true);
        // }
        File::ensureDirectoryExists($directory, 0755, true);

        if(!File::isDirectory($directory)) {
            throw new \Exception('error permission directory');
        }

        // Delete the old image
        // if($old_image !== null){
        //     $file =  public_path($old_image);
        //     if(File::exists($file)){
        //         File::delete($file);
        //     }
        // }
        
        $manager->save($directory . $image_name);
        
        $size = File::size($directory . $image_name);
        $user_id = auth()->user()->id;
        
        $media = Media::create([
            'name'      => $name,
            'user_id'   => $user_id,
            'type'      => 'image',
            'extension' => $extension,
            'size'      => $size,
            'original_file'  => $image_name,
            'image_variants' => []
        ]);
        // dd(mime_content_type($path . $image_name));
        return $media;      
    }


    public function saveFile($request_file, $nameFile)
    {
        if($nameFile){
            $name = $nameFile;

        }else{
            $name_arr = explode('.', $request_file->getClientOriginalName());
            array_pop($name_arr);
            $name = join('.',$name_arr);
            if(strlen($name) > 100){
                throw  new \Exception(__('Name of image too long'));
            }
        }

        $type = explode('/', $request_file->getMimeType())[0];

        $user_id        = auth()->user()->id;
        $size           = $request_file->getSize();
        $extension      = $request_file->getClientOriginalExtension();
        $type           = $type == 'application' ? 'document' : $type;

        // $content_type   = ['visibility' => 'public', 'ContentType' => $extension == 'svg' ? 'image/svg+xml' : $mime_type];
        $originalFile   = date('YmdHis') . "_original_" . rand(1, 500) . '.' . $extension;
        $directory      = public_path('/storage/media/files/');

        Log::info($originalFile);
        File::ensureDirectoryExists($directory, 0755, true);
        $request_file->move($directory, $originalFile);

        $media = Media::create([
            'name'      => $name,
            'user_id'   => $user_id,
            'type'      => $type,
            'extension' => $extension,
            'size'      => $size,
            'original_file'=> 'files/'.$originalFile,
            'image_variants' => []
        ]);
        return $media;
    }

    public function deleteImage($image)
    {
        $path = public_path('/storage/images/'.$image);
        if(File::exists($path)){
            return File::delete($path);
        }else{
            return false;
        }
    }

    public function deleteFile($file)
    {
        $path = public_path('/storage/media/'.$file);
        if(File::exists($path)){
            return File::delete($path);
        }else{
            return false;
        }
    }
    
}

