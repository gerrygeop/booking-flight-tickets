<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePassengerDetailRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'passengers' => 'required|array|min:1',
            'passengers.*.name' => 'required',
            'passengers.*.date_of_birth' => 'required',
            'passengers.*.nationality' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'passengers.*.name' => 'Passenger name',
            'passengers.*.date_of_birth' => 'Passenger date of birth',
            'passengers.*.nationality' => 'Passenger nationality',
        ];
    }

    public function messages()
    {
        return [
            'passengers.*.name.required' => ':attribute field is required'
        ];
    }
}
