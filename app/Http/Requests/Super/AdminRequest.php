<?php

namespace App\Http\Requests\Super;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 * Validasi tambah akun admin, ubah data admin, dan reset password admin.
 */
class AdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->routeIs('sup.*') && Auth::check();
    }

    public function rules(): array
    {
        $password = ['required', 'confirmed', Password::defaults()];
        $user = $this->route('user');
        // Email unik di semua akun, termasuk yang terhapus (akun terhapus masih bisa dipulihkan).
        $email = ['required', 'string', 'email', 'max:255', Rule::unique(User::class, 'email')->ignore($user instanceof User ? $user->id : null)];

        return match (true) {
            $this->routeIs('sup.admin.password') => ['password' => $password],
            $this->routeIs('sup.admin.update') => ['name' => 'required|string|max:100', 'email' => $email],
            default => ['name' => 'required|string|max:100', 'email' => $email, 'password' => $password],
        };
    }

    public function messages(): array
    {
        return [
            'name.required' => "Nama wajib diisi!",
            'name.max' => "Nama maksimal 100 karakter!",
            'email.required' => "Email wajib diisi!",
            'email.email' => "Format email tidak valid!",
            'email.unique' => "Email sudah dipakai akun lain (termasuk akun yang terhapus)!",
            'password.required' => "Password wajib diisi!",
            'password.confirmed' => "Konfirmasi password tidak sama!",
            'password.min' => "Password minimal :min karakter!",
        ];
    }
}
