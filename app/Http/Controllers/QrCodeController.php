<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function show(Request $request)
    {
        $url = $request->input('chl');
        return QrCode::size(500)
            ->generate(
            $url
        );
    }    
}
