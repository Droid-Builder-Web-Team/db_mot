<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class SettingsController
 *
 * Handles the display of the global settings dashboard in the admin panel.
 */
class SettingsController extends Controller
{
    /**
     * SettingsController constructor.
     * Enforces authentication for accessing settings.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the main settings dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.settings.index');
    }
}
