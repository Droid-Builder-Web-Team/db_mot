<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\PartsRunData;
use App\PartsRunImage;

class PartsRunImageController extends Controller
{
    public function show($id, $number = 1, $size = 'full')
    {
        $partrun = PartsRunData::find($id);
        $images = $partrun->images;
        $image = $images[$number - 1];

        $folderPath = 'parts-run/'.$id;
        if ($size == 'full')
          $fileName = $image->filename;
        else
          $fileName = $size.'_'.$image->filename;

        $file = Storage::get($folderPath.'/'.$fileName);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $image->filetype);

        return $response;

    }
}
