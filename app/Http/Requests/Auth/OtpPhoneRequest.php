<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OtpPhoneRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'device_id' => 'required|string|max:255',
            'phone' => 'required_without:email|regex:/(62)[0-9]{9}/|max:20',
            'email' => 'required_without:phone|string|email|max:255',
            'type' => 'required|string'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'please check input form',
            'errors' => $validator->errors()
        ], 422));
    }
}
