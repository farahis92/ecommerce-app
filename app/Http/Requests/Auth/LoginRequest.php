<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'phone' => 'required|regex:/(62)[0-9]{9}/',
            'password' => 'required|string|digits:6'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = \Respond::respondValidationError(
            'please check input',
            $validator->errors()->toArray()
        );
        throw new HttpResponseException($response);
    }

}
