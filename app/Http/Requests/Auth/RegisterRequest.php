<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|regex:/(62)[0-9]{9}/|unique:users|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|max:6'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Please Check Input Phone or Password',
            'errors' => $validator->errors()
        ], 422));
    }
}
