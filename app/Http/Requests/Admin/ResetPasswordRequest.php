<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

/**
 * Admin mereset password agen / pencari properti (selama fitur lupa password lewat email belum aktif).
 */
class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->routeIs('adm.*') && Auth::check();
    }

    public function rules(): array
    {
        return [
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => "Password baru wajib diisi!",
            'password.confirmed' => "Konfirmasi password tidak sama!",
            'password.min' => "Password minimal :min karakter!",
        ];
    }
}
