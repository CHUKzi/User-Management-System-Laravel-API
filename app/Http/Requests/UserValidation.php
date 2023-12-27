<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UserValidation extends FormRequest
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
        $user_id = $this->route('id');

        $rules = [
            'first_name' => 'required|string|min:2|max:55',
            'last_name' => 'required|string|min:2|max:55',
            'email' => [
                'required',
                'email',
                'min:2',
                'max:55',
                Rule::unique('users', 'email')->ignore($user_id),
            ],
            'mobile' => [
                'required',
                'string',
                'max:15',
                Rule::unique('users', 'mobile')->ignore($user_id),
            ],
        ];

        if ($this->isMethod('post')) {
            $rules['password'] = 'required|string|min:6|confirmed';
            $rules['password_confirmation'] = 'required|string|min:6';
        }

        return $rules;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'=> false,
            'message'=> 'Form errors encountered. Please review.',
            'data'=> null,
            'errorMessages' => $validator->errors(),
        ]));
    }
}
