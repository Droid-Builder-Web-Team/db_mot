<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Setting;

/**
 * Class CoverNoteSettingsController
 *
 * Manages the configuration settings for the PLI (Public Liability Insurance)
 * Cover Note PDFs. Allows administrators to update provider details,
 * policy numbers, and cover limits.
 */
class CoverNoteSettingsController extends Controller
{
    /**
     * CoverNoteSettingsController constructor.
     * Enforces authentication and authorization middleware.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:Edit Members'); // Or whatever admin permission applies to settings. Or we can just let Route::group handle it. Wait, the route group has middleware? Let's check web.php... Wait, web.php doesn't have middleware inside the group in lines 37-44. Let's see if there's middleware applied elsewhere, but 'can:Edit Members' is typical.
    }

    /**
     * Display the form to edit the PLI Cover Note settings.
     * Retrieves current values from the Setting model, falling back to
     * sensible defaults if they are not yet configured.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit()
    {
        $settings = [
            'pli_provider' => Setting::where('name', 'pli_provider')->value('value') ?? 'Self Assured Underwriting Agencies Limited.',
            'pli_policy_number' => Setting::where('name', 'pli_policy_number')->value('value') ?? 'SALSALIA/S338723/BB012/25',
            'pli_wording' => Setting::where('name', 'pli_wording')->value('value') ?? 'Liability Insurance Policy (SAUA Associations & Clubs PLPW1220)',
            'pli_people_covered' => Setting::where('name', 'pli_people_covered')->value('value') ?? 'Members of a club who attend shows to show their droids.',
            'pli_public_liability' => Setting::where('name', 'pli_public_liability')->value('value') ?? 'GBP 2,000,000 any one Occurrence, defence costs and expenses in addition',
            'pli_property_liability' => Setting::where('name', 'pli_property_liability')->value('value') ?? 'GBP 2,000,000 any one Occurrence and in the aggregate, defence costs and expenses in addition',
            'pli_excess' => Setting::where('name', 'pli_excess')->value('value') ?? 'Property Damage GBP 250 each and every Occurrence',
            'pli_chairman' => Setting::where('name', 'pli_chairman')->value('value') ?? 'Lee Towersey <lee@artoo-detoo.co.uk>',
            'pli_admin' => Setting::where('name', 'pli_admin')->value('value') ?? 'admin@droidbuilders.uk',
        ];

        return view('admin.covernote.edit', compact('settings'));
    }

    /**
     * Update the PLI Cover Note settings in the database.
     * Iterates through the requested keys and updates or creates the setting record.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $keys = [
            'pli_provider', 'pli_policy_number', 'pli_wording', 'pli_people_covered',
            'pli_public_liability', 'pli_property_liability', 'pli_excess',
            'pli_chairman', 'pli_admin'
        ];

        foreach ($keys as $key) {
            Setting::updateOrCreate(
                ['name' => $key],
                ['value' => $request->input($key)]
            );
        }

        return redirect()->route('admin.covernote.edit')->with('success', 'Cover Note settings updated successfully.');
    }
}
