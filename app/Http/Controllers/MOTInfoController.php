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
        $sections = DB::table('mot_sections')->where('club_id', $id)->get();

        $lines = [];

        foreach ($sections as $section)
        {
            $lines[$section->id] = DB::table('mot_lines')
                ->where('section_id', $section->id)
                ->get();
        }
        $club = Club::find($id);
        // share data to view
        $pdf = PDF::loadView('pdfs.motinfo', compact('sections', 'lines', 'club'));

        // download PDF file with download method
        return $pdf->download('MOT Info.pdf');
    }

    public function exportMotTest($id)
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
        // share data to view
        $pdf = PDF::loadView('pdfs.mottest', compact('sections', 'lines', 'club'));

        // download PDF file with download method
        return $pdf->download('MOT Test.pdf');
    }
}
