<?php

namespace App\Http\Controllers;

use PDF;
use App\Club;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MOTInfoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clubs = Club::all();
        return view('motinfo.index', compact('clubs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sections = DB::table('mot_sections')
            ->where('club_id', $id)
            ->get();

        $lines = [];

        foreach ($sections as $section)
        {
            $lines[$section->id] = DB::table('mot_lines')
                ->where('section_id', $section->id)
                ->get();
        }
        $mot_officers = [];
        $club = Club::find($id);
        foreach (User::role('MOT Officer')->get() as $officer)
        {
            if ($officer->isAdminOf($club))
            {
                $mot_officers[] = $officer;
            }

        }
        return view('motinfo.show', compact('sections', 'lines', 'mot_officers'));
    }

    public function exportMotInfo($id)
    {
        // retreive all records from db
        $data = DB::table('mot_sections')->where('club_id', $id)->get();

        // share data to view
        view()->share('sections',$data);
        $pdf = PDF::loadView('pdfs.motinfo', $data);

        // download PDF file with download method
        return $pdf->download('pdfs.motinfo.pdf');
    }
}
