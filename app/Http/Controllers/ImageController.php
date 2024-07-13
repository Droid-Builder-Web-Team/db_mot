<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Droid;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    public function index(Request $request)
    {
        return view('image', compact('request'));
    }

    public function upload(Request $request)
    {
        $droid = Droid::find($request->droid);
        $user = User::find($request->user);
        $folderPath = $request->photo_name;
        switch($request->photo_name) {
            case 'mug_shot':
                $folderPath = 'members/'.$request->user.'/';
                if ($user != auth()->user() && !auth()->user()->can('Edit Members')) {
                    abort(403);
                }
                break;
            case 'topps_front':
            case 'topps_rear':
            case 'photo_front':
            case 'photo_side':
            case 'photo_rear':
                $folderPath = 'droids/'.$request->droid.'/';
                if (!$droid->users->contains(auth()->user()) && !auth()->user()->can('Edit Droids')) {
                    abort(403);
                }
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

        Storage::put($file, $image_base64);

        $img = \Image::make(Storage::get($file))->resize(
            480,
            null,
            function ($constraint) {
                $constraint->aspectRatio();
            }
        );
        $file = $folderPath . '480-' . $request->photo_name . '.png';
        Storage::put($file, $img->encode());

        $img = \Image::make(Storage::get($file))->resize(
            240,
            null,
            function ($constraint) {
                $constraint->aspectRatio();
            }
        );
        $file = $folderPath . '240-' . $request->photo_name . '.png';
        Storage::put($file, $img->encode());

        flash()->addSuccess('Image uploaded successfully');

        return response()->json(
            ['success' => 'success',
                        'sentsize' => $request->image_size,
                        'receivedsize' => strlen($image_base64),
            ]
        );
    }

    public function destroy(Request $request)
    {

        $folderPath = $request->photo_name;
        switch($request->photo_name) {
            case 'mug_shot':
                $folderPath = 'members/'.$request->user.'/';
                if ($user != auth()->user() && !auth()->user()->can('Edit Members')) {
                    abort(403);
                }
                break;
            case 'photo_front':
            case 'photo_side':
            case 'photo_rear':
                $folderPath = 'droids/'.$request->droid.'/';
                $droid = Droid::find($request->droid);
                if (!$droid->users->contains(auth()->user()) && !auth()->user()->can('Edit Droids')) {
                    abort(403);
                }
                break;
            case 'default':
                $folderPath = '/';
                break;
        }

        $image_array = array(
            $folderPath.$request->photo_name.'.jpg',
            $folderPath.$request->photo_name.'.png',
            $folderPath.'240-'.$request->photo_name.'.png',
            $folderPath.'480-'.$request->photo_name.'.png'
        );

        Storage::delete($image_array);

        flash()->addSuccess('Image deleted successfully');
        return redirect()->route('droid.show', $request->droid);
    }

    public function update()
    {
        $droids = Droid::all();
        $pic_types = [
            'photo_front',
            'photo_side',
            'photo_rear',
            'topps_front',
            'topps_rear'
        ];

        foreach($droids as $droid) {
            echo "Updating images for: ".$droid->name. " ID: ".$droid->id."<br>";
            foreach($pic_types as $type) {
                echo "Checking for: ".$type." ";
                $path = 'droids/'.$droid->id.'/'.$type.'.png';
                if (!Storage::exists($path)) {
                    $path = 'droids/'.$droid->id.'/'.$type.'.jpg';
                }
                if (Storage::exists($path)) {
                    $folderPath = 'droids/'.$droid->id.'/';
                    $img = \Image::make(Storage::get($path))->resize(
                        480,
                        null,
                        function ($constraint) {
                            $constraint->aspectRatio();
                        }
                    );
                    $file = $folderPath . '480-' . $type . '.png';
                    Storage::put($file, $img->encode());

                    $img = \Image::make(Storage::get($file))->resize(
                        240,
                        null,
                        function ($constraint) {
                            $constraint->aspectRatio();
                        }
                    );
                    $file = $folderPath . '240-' . $type . '.png';
                    Storage::put($file, $img->encode());
                }
            }
            echo "<br>";
        }
    }
}
