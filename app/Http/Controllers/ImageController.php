<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index(Request $request)
    {
        return view('image', compact('request'));
    }

    public function upload(Request $request)
    {
        $folderPath = $request->photo_name;
        switch($request->photo_name) {
            case 'mug_shot':
                $folderPath = 'members/'.$request->user.'/';
                break;
            case 'photo_front':
            case 'photo_side':
            case 'photo_rear':
                $folderPath = 'droids/'.$request->droid.'/';
                break;
            case 'default':
                $folderPath = '/';
                break;
        }

        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . $request->photo_name . '.png';

        Storage::disk('local')->put($file, $image_base64);

        $img = \Image::make(Storage::get($file))->resize(480, null, function($constraint) {
            $constraint->aspectRatio();
        });
        $file = $folderPath . '480-' . $request->photo_name . '.png';
        Storage::disk('local')->put($file, $img->encode());

        $img = \Image::make(Storage::get($file))->resize(240, null, function($constraint) {
            $constraint->aspectRatio();
        });
        $file = $folderPath . '240-' . $request->photo_name . '.png';
        Storage::disk('local')->put($file, $img->encode());

        return response()->json(['success'=>'success',
                        'sentsize'=>$request->image_size,
                        'receivedsize'=>strlen($image_base64),
                      ]);
    }
}
