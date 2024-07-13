<?php

/**
 * Contact Controller
 * php version 7.4
 *
 * @category Controller
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

namespace App\Http\Controllers\Admin;

use App\Location;
use App\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\ContactDataTable;

/**
 * ContactController
 *
 * @category Class
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class ContactController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:Edit Events');
    }

    /**
     * Display a listing of the resource.
     *
     * @param ContactDataTable $dataTable Datatable object
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ContactDataTable $dataTable)
    {
        return $dataTable->render('admin.contacts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contact $contact Contact to show
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view(
            'admin.contacts.create'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request HTTP Request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
            'name' => 'required',
            ]
        );

        try {
            Contact::create($request->all());
            flash()->addSuccess('Contact created successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to create Contact');
        }

        return redirect()->route('admin.contacts.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Contact $contact Contact to Edit
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        return view('admin.contacts.edit')->with('contact', $contact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request Data to update
     * @param \App\Contact             $contact Contact to update
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate(
            [
            'name' => 'required',
            ]
        );

        try {
            $contact->update($request->all());
            flash()->addSuccess('Contact updated successfully');
        } catch (\Illuminate\Database\QueryException $exception) {
            flash()->addError('Failed to update Contact');
        }

        return redirect()->route('admin.contacts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Contact $contact Contact to destroy
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact deleted successfully');
    }

    /**
     * Link a contact to a model
     *
     * @param  \Illuminate\Http\Request $request HTTP Request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function link(Request $request)
    {
        $model = app($request->model_type)::find($request->model_id);
        $model->contacts()->attach($request->contact_id);

        return back();
    }

    /**
     * Unlink a contact from a model
     *
     * @param  \Illuminate\Http\Request $request HTTP Request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unlink(Request $request)
    {
        $model = app($request->model_type)::find($request->model_id);
        $model->contacts()->detach($request->contact_id);

        return back();
    }
}
