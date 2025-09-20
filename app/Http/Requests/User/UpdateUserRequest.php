<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'employee_card_id' => 'sometimes|string|unique:users,employee_card_id,' . $this->user,
            'first_name' => 'sometimes|string|max:50',
            'last_name'  => 'sometimes|string|max:50',
            'email'      => 'sometimes|email|unique:users,email,' . $this->user,
            'password'   => [
                'required',
                'string',
                'min:8', // minimal 8 karakter
                'regex:/[a-z]/',      // harus ada huruf kecil
                'regex:/[A-Z]/',      // harus ada huruf besar
                'regex:/[0-9]/',      // harus ada angka
                'regex:/[@$!%*?&]/'   // harus ada karakter spesial
            ],
            'role_id'    => 'sometimes|exists:roles,id',
            'division_id'=> 'sometimes|exists:divisions,id',
            'position_id'=> 'sometimes|exists:positions,id',
            'manager_id' => 'sometimes|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ];
    }
}
