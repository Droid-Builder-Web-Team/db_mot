<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Setting;

/**
 * Class PLILevelSettingsController
 *
 * Manages the dynamic list of PLI Levels (Static, Driving, etc.)
 */
class PLILevelSettingsController extends Controller
{
    /**
     * PLILevelSettingsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:Edit Members');
    }

    /**
     * Display the form to edit the PLI levels.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit()
    {
        $levelsJson = Setting::where('name', 'pli_levels')->value('value');
        $levels = $levelsJson ? json_decode($levelsJson, true) : ['Static' => 10, 'Driving' => 20];
        
        $lines = [];
        foreach ($levels as $name => $price) {
            $lines[] = $name . ':' . $price;
        }
        $levelsText = implode("\n", $lines);

        return view('admin.settings.pli_levels', compact('levelsText'));
    }

    /**
     * Update the PLI levels in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'pli_levels' => 'required|string'
        ]);

        $lines = explode("\n", $request->input('pli_levels'));
        $levels = [];
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }
            
            if (strpos($line, ':') !== false) {
                list($name, $price) = explode(':', $line, 2);
                $levels[trim($name)] = trim($price);
            } else {
                // Default price if they forgot the colon
                $levels[$line] = 0;
            }
        }

        Setting::updateOrCreate(
            ['name' => 'pli_levels'],
            ['value' => json_encode($levels)]
        );

        return redirect()->route('admin.settings.index')->with('success', 'PLI Levels updated successfully.');
    }
}
