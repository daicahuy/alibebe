<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'phone_number'    => ['required', 'string', Rule::unique('users'), 'max:20'],
            'email'           => ['required', 'email', Rule::unique('users'), 'max:100'],
            'fullname'        => ['required', 'string', 'max:100'],
            'role'            => ['required', Rule::in(0, 1, 2)],
            'password'        => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

}
