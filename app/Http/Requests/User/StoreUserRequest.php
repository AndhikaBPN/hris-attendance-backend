<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'employee_card_id' => 'string|unique:users,employee_card_id',
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'email'      => 'required|email|unique:users,email',
            'password'   => [
                'required',
                'string',
                'min:8', // minimal 8 karakter
                'regex:/[a-z]/',      // harus ada huruf kecil
                'regex:/[A-Z]/',      // harus ada huruf besar
                'regex:/[0-9]/',      // harus ada angka
                'regex:/[@$!%*?&]/'   // harus ada karakter spesial
            ],
            'role_id'    => 'required|exists:roles,id',
            'division_id'=> 'nullable|exists:divisions,id',
            'position_id'=> 'nullable|exists:positions,id',
            'manager_id' => 'nullable|exists:users,id',
            'photo'      => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
            'phone'      => 'required|string|max:15',
            'address'    => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ];
    }
}
