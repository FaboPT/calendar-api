<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

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
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
        ];

    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     */
    /* protected function failedValidation(Validator $validator)
     {
         $errors = (new ValidationException($validator))->errors();

         throw new HttpResponseException(
             response()->json(['errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY)
         );
     }*/


}
