<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MOTStoreRequest extends FormRequest
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
            'date' => 'required',
            'location' => 'required',
            'droid_id' => 'required',
            'approved' => 'required',
            'mot_type' => 'required',
            'user' => 'required',
        ];
    }
}
