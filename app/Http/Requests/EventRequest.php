<?php
/**
 * Asset Request
 * php version 8.2
 *
 * @category Controller
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
        //Auth::user()->hasRole(['Super Admin', 'Org Admin', 'Quartermaster']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'date' => 'required|date|after:tomorrow',
            'location_id' => 'required|doesnt_start_with:---'
        ] + ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store()
    {

        return [
            'location_name' => ['required_if:location_id,new'],
            'postcode' => ['required_if:location_id,new'],
            'town' => ['required_if:location_id,new']
        ];
    }

    protected function update()
    {
        return [
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'This field is required',
            'description.required' => 'A description of the event is required',
            'date.after' => 'Please set a valid date in the future',
            'location_name.required_if' => 'Please supply a name for this location',
            'postcode.required_if' => 'A postcode is required',
            'town.required_if' => 'Please enter a town for the location',
            'location_id.doesnt_start_with' => 'Please select an existing location, or enter a new one'
        ];
    } 
}
