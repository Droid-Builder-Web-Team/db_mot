<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePartsRunRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'history' => 'nullable',
            'price' => 'required|',
            'includes' => 'required',
            'instructions_id' => 'required',
            'location' => 'required',
            'shipping_costs' => 'required',
            'purchase_url' => 'required',
            'contact_email' => 'required',
        ];
    }
}
