<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdatePharmacyRequest extends FormRequest
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
            'name' => 'required|unique:pharmacies|max:25',
            'town' => 'required',
            'municipality' => 'required',
            'address' => 'required',
            'add_address' => 'nullable',
            'phone' => 'required|digits:8',
            'am' => 'required|digits:4'
        ];
    }
}
