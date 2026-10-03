<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Role as RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register2', [
            'title' => "Daftar | ".config('georestate.nama'),
        ]);
    }

    /**
     * Handle an incoming registration request.
     * User bisa mendaftar sebagai pencari properti (user) atau agen.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', Rule::in(RoleEnum::registrable())],
            'phone' => ['nullable', 'required_if:role,'.RoleEnum::Agen->value, 'string', 'max:20'],
        ], [
            'role.required' => 'Silahkan pilih jenis akun.',
            'role.in' => 'Jenis akun tidak valid.',
            'phone.required_if' => 'Nomor telepon wajib diisi untuk akun agen.',
        ]);

        $user = DB::transaction(function () use ($request) {
            $role = RoleEnum::from($request->role);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => Role::firstOrCreate(['name' => $role->value])->id,
            ]);

            if ($role === RoleEnum::Agen) {
                Agent::create([
                    'user_id' => $user->id,
                    'member_identifier' => (string) Str::ulid(),
                    'phone' => $request->phone,
                ]);
            }

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect($user->homeUrl());
    }
}
