<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class NominationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'nominee_id' => 'required',
            'reason' => 'required'
        ] + ($this->isMethod('POST') ? $this->store() : $this->update());
    }


    protected function store()
    {
        return [
        ];
    }

    protected function update()
    {
        return [
            'user_id' => 'required',
            'current_holder_id' => 'required',
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
            'nominee_id.required' => 'This field is required',
            'reason.required' => 'A reason is required',
        ];
    }
}
