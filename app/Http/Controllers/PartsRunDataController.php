<?php

/**
 * Parts Run Data Controller
 * php version 7.4
 *
 * @category Controller
 * @package  Controllers
 * @author   Rob Howdle <robhowdle94@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

namespace App\Http\Controllers;

use App\User;
use App\Club;
use App\Comment;
use App\PartsRunAd;
use App\Instructions;
use App\PartsRunData;
use App\PartsRunImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePartsRunRequest;
use App\Notifications\PartsRunUpdated;
use App\Notifications\PartsRunFull;

/**
 * Parts Run Controller
 *
 * @category Class
 * @package  Controllers
 * @author   Rob Howdle <robhowdle94@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class PartsRunDataController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $partsRunData = app(PartsRunData::class)
            ->with(['partsRunAd'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view(
            'parts-run.list',
            [
            'partsRunData' => $partsRunData,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        if (!auth()->user()->can('Create Partrun')) {
            abort(403);
        }
        $clubs = Club::all();
        $runners = User::permission('Edit Partrun')->get();

        return view(
            'parts-run.create',
            [
            'clubs' => $clubs,
            'runners' => $runners,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request POST data passed to function
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('Create Partrun')) {
            abort(403);
        }

        $email = User::find($request->user_id)->email;
        $location = User::find($request->user_id)->county;

        // Parts Run Data - RH
        $partsRunData = app(PartsRunData::class)->create(
            [
            'club_id' => $request->club_id,
            'bc_rep_id' => Auth::user()->id,
            'user_id' => $request->user_id,
            'status' => "Initial",
            ]
        );
        $partsRunData->save();

        // Parts run data. To be created last - RH
        $partsRunAd = app(PartsRunAd::class)->create(
            [
            'parts_run_data_id' => $partsRunData->id,
            'contact_email' => $email,
            'location' => $location,
            'title' => $request->title
            ]
        );

        $partsRunAd->save();

        return redirect()->route('parts-run.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id $ID of part run to display
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $partsRunData = PartsRunData::where('id', $id)->with('partsRunAd')->get();
        foreach ($partsRunData as $include) {
            $includesArray = explode(",", $include->partsRunAd->includes);
        };

        $shippingCostsArray = array();
        if ($partsRunData[0]->partsRunAd->shipping_costs != null) {
            foreach ($partsRunData as $shippingCosts) {
                $shippingCostsArray = explode(
                    ",",
                    $shippingCosts->partsRunAd->shipping_costs
                );
            };
        };

        return view(
            'parts-run.show',
            [
            'data' => $partsRunData[0],
            'includesArray' => $includesArray,
            'shippingCostsArray' => $shippingCostsArray
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.z
     *
     * @param int $id Id of Part Run
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        if (!auth()->user()->can('Edit Partrun')) {
            abort(403);
        }
        $clubs = Club::all();
        $partsRunData = PartsRunData::where('id', $id)->get();

        foreach ($partsRunData as $include) {
            $includesArray = explode(",", $include->partsRunAd->includes);
            // Implode to return as a string when displaying update form - RH
            $includes = implode(",", $includesArray);
        };

        foreach ($partsRunData as $shippingCosts) {
            $shippingCostsArray = explode(
                ",",
                $shippingCosts->partsRunAd->shipping_costs
            );
            // Implode to return as a string when displaying update form - RH
            $shipping = implode(",", $shippingCostsArray);
        };

        return view(
            'parts-run.edit',
            [
            'partsRunData' => $partsRunData,
            'includes' => $includes,
            'shipping' => $shipping,
            'clubs' => $clubs
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request POST data from form
     * @param int                      $id      ID of Part run to update
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function update(Request $request, $id)
    {

        $partsRunData = app(PartsRunData::class)->find($id);

        // Only people with Edit Partrun can edit this page
        if (!auth()->user()->can('Edit Partrun')) {
            abort(403);
        }

        if (!auth()->user()->id == $partsRunData->user_id
            && !auth()->user()->can('Create Partrun')
        ) {
            abort(403);
        }

        $data = $request->except(['_method', '_token']);

        if ($partsRunData->status != $request->status) {
            foreach ($partsRunData->isInterested as $user) {
                $user->notify(new PartsRunUpdated($partsRunData));
            }
            $bc_rep = User::find($partsRunData->bc_rep_id)->first();
            $bc_rep->notify(new PartsRunUpdated($partsRunData));
        }


        $partsRunData->update(
            [
            'status' => $request->status,
            'open' => $request->open
            ]
        );

        if (($request->purchase_url_type == "paypalme"
            || $request->purchase_url_type == "website")
            && $request->purchase_url != ""
        ) {
            if (!str_starts_with($request->purchase_url, 'http')) {
                $request->purchase_url = "https://".$request->purchase_url;
            }
        }

        $partsRunData->partsRunAd()->update(
            [
            'title' => $request->title,
            'description' => $request->description,
            'history' => $request->history,
            'price' => $request->price,
            'includes' => $request->includes,
            'location' => $request->location,
            'shipping_costs' => $request->shipping_costs,
            'purchase_url' => $request->purchase_url,
            'purchase_url_type' => $request->purchase_url_type,
            'contact_email' => $request->contact_email,
            'quantity' => $request->quantity,
            'reserve' => $request->reserve
            ]
        );

        return redirect()->route('parts-run.show', $partsRunData->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\PartsRunData $partsRunData PartsRunData model
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function destroy(PartsRunData $partsRunData)
    {
        // Commented out, we don't want to delete part runs at all.
        // $partsRunData = app(PartsRunData::class)
        //  ->find($partsRunData->id)->destroy();
        return back();
    }

    /**
     * Request PartsRun
     *
     * @param \Illuminate\Http\Request $request Form data
     *
     * @return string
     */
    public function requestPartsRun(Request $request)
    {
        return "Request a Parts Run";
    }

    /**
     * Register interest in run
     *
     * @param \Illuminate\Http\Request $request  Form data
     * @param \App\PartsRunData        $partsrun Part run model
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function interested(Request $request, PartsRunData $partsrun)
    {

        $request->validate(
            [
            'quantity' => 'integer'
            ]
        );

        if (((($partsrun->partsRunAd->quantity + $partsrun->partsRunAd->reserve) <= $partsrun->interestQuantity()) && $request->interest == 'interested')
            && $partsrun->partsRunAd->quantity != 0
        ) {
            flash()->addError('Part Run Full');
            return back();
        }
        $user = auth()->user();
        $hasEntry = $user->partsInterested()
            ->where('parts_run_data_id', $partsrun->id)->exists();
        $attributes = [
          'status' => $request->interest,
          'quantity' => $request->quantity
        ];
        if ($hasEntry) {
            if ($request->interest == "no") {
                $result = $partsrun->isInterested()->detach($user);
            } else {
                $result = $partsrun->interested()
                    ->updateExistingPivot($user, $attributes);
            }
        } else {
            $result = $partsrun->interested()->save($user, $attributes);
        }
        flash()->addSuccess('Interest registered for Parts Run');

        $partsrun = $partsrun->fresh();

        // Notify Part runner if quantity is reached
        if ($partsrun->partsRunAd->quantity == $partsrun->interestQuantity() && $partsrun->partsRunAd->quantity != 0) {
            $partsrun->user->notify(new PartsRunFull($partsrun));
        }
        return back();
    }

    /**
     * Status update
     *
     * @param \Illuminate\Http\Request $request Form data
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function statusUpdate(Request $request)
    {
        $partsrun = PartsRunData::find($request->run_id);
        if (!Auth::user()->id != $partsrun->user_id
            && !Auth::user()->can('Create Partrun')
        ) {
            return abort(403);
        }
        $status_array = array('paid','shipped','no');

        if (in_array($request->status, $status_array)) {
            $user = User::find($request->user_id);
            $attributes = [
                'status' => $request->status,
                'shipper' => $request->shipper ??  '',
                'tracking' => $request->tracking ?? ''
            ];
            if ($request->status == "no") {
                $partsrun->isInterested()->detach($user);
            } else {
                try {
                    $result = $partsrun->interested()
                        ->updateExistingPivot($user, $attributes);
                    flash()->addSuccess('Status Updated');
                } catch (Exception $e) {
                    flash()->addError('Status Update failed');
                }
            }
        }
        return back();
    }

    /**
     * Export as CSV
     *
     * @param int $id Part run id
     *
     * @return void
     */
    public function export($id)
    {
        if (!auth()->user()->can('Edit Partrun')) {
            abort(403);
        }

        $partsRunData = app(PartsRunData::class)->find($id);
        if (auth()->user()->id != $partsRunData->user_id) {
            abort(403);
        }

        $fileName = 'interest.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array(
            'Forename',
            'Surname',
            'email',
            'Country',
            'Quantity',
            'Status',
            'Date Added'
        );

        $callback = function () use ($partsRunData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($partsRunData->interested as $user) {
                $row['Forename']  = $user->forename;
                $row['Surname']    = $user->surname;
                $row['email']    = $user->email;
                $row['country'] = $user->country;
                $row['Quantity']  = $user->pivot->quantity;
                $row['Status']  = $user->pivot->status;
                $row['Date Added'] = $user->pivot->timestamp;

                fputcsv(
                    $file,
                    array(
                        $row['Forename'],
                        $row['Surname'],
                        $row['email'],
                        $row['country'],
                        $row['Quantity'],
                        $row['Status'],
                        $row['Date Added']
                    )
                );
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * List none active runs
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function noneActiveRuns()
    {
        $inactivePartsRunData = app(PartsRunData::class)
            ->with(['partsRunAd'])
            ->where('status', '=', 'Inactive')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view(
            'parts-run.none-active-runs',
            [
                'inactivePartsRunData' => $inactivePartsRunData,
            ]
        );
    }
}
