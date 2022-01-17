<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Club;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MOTDesignController extends Controller
{
    public function edit($id)
    {
        // retreive all records from db
        $sections = DB::table('mot_sections')->where('club_id', $id)->get();

        $lines = [];

        foreach ($sections as $section)
        {
            $lines[$section->id] = DB::table('mot_lines')
                ->where('section_id', $section->id)
                ->get();
        }
        $club = Club::find($id);

        return view('admin.mot.edit', compact('sections', 'lines', 'club'));
    }

    public function update(Request $request)
    {
        dd($request);
    }
}
