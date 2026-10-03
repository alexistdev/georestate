<?php

namespace App\Http\Requests\Agen;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Ganti email login agen; wajib password saat ini.
 */
class EmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->routeIs('agn.*') && Auth::check();
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class, 'email')->ignore($this->user()->id)],
            'current_password' => ['required', 'current_password'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => "Email wajib diisi!",
            'email.email' => "Format email tidak valid!",
            'email.unique' => "Email sudah dipakai akun lain!",
            'current_password.required' => "Masukkan password saat ini untuk mengganti email!",
            'current_password.current_password' => "Password saat ini salah!",
        ];
    }
}
