<?php

namespace App\Http\Controllers\Super;

use App\Enums\Role as RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Super\AdminRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Kelola akun admin (khusus super admin). Super admin hanya bisa membuat akun Admin,
 * bukan Super; akun super dikelola lewat seeder/terminal.
 */
class AdminController extends Controller
{
    public function index(Request $request)
    {
        $terhapus = $request->query('tab') === 'terhapus';
        $kata = $request->query('q');
        $kata = is_string($kata) && trim($kata) !== '' ? Str::limit(trim($kata), 100, '') : null;

        $admins = $this->admin($terhapus)
            ->when($kata, fn (Builder $q) => $q->where(
                fn (Builder $q) => $q->where('name', 'like', "%{$kata}%")->orWhere('email', 'like', "%{$kata}%")
            ))
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('super.admin', array(
            'judul' => "Kelola Admin | GeoRestate v.1.0",
            'menuUtama' => 'admin',
            'menuKedua' => 'admin',
            'dataAdmin' => $admins,
            'terhapus' => $terhapus,
            'kata' => $kata,
            'jumlahAktif' => $this->admin(false)->count(),
            'jumlahTerhapus' => $this->admin(true)->count(),
        ));
    }

    public function store(AdminRequest $request)
    {
        $admin = User::create([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'password' => Hash::make($request->validated('password')),
            'role_id' => Role::firstOrCreate(['name' => RoleEnum::Admin->value])->id,
        ]);

        return redirect(route('sup.admin'))
            ->with(['success' => "Akun admin {$admin->email} berhasil dibuat. Sampaikan password awalnya dan minta admin menggantinya lewat menu Ubah Password."]);
    }

    public function update(AdminRequest $request, User $user)
    {
        $this->pastikanAdmin($user);
        $user->update($request->safe()->only(['name', 'email']));

        return redirect(route('sup.admin'))->with(['success' => "Data admin {$user->email} berhasil diubah."]);
    }

    public function resetPassword(AdminRequest $request, User $user)
    {
        $this->pastikanAdmin($user);
        $user->update(['password' => Hash::make($request->validated('password'))]);

        return redirect(route('sup.admin'))->with(['success' => "Password admin {$user->email} berhasil direset."]);
    }

    public function destroy(User $user)
    {
        $this->pastikanAdmin($user);
        abort_if($user->is(Auth::user()), 403, 'Anda tidak bisa menghapus akun Anda sendiri.');
        $user->delete();

        return redirect(route('sup.admin'))
            ->with(['delete' => "Akun admin {$user->email} dihapus. Akun tidak bisa login, tapi masih bisa dipulihkan dari tab Terhapus."]);
    }

    public function restore(User $user)
    {
        $this->pastikanAdmin($user);
        abort_unless($user->trashed(), 404);
        $user->restore();

        return redirect(route('sup.admin', ['tab' => 'terhapus']))->with(['success' => "Akun admin {$user->email} berhasil dipulihkan."]);
    }

    private function admin(bool $terhapus): Builder
    {
        return User::query()
            ->when($terhapus, fn (Builder $q) => $q->onlyTrashed())
            ->whereHas('role', fn (Builder $q) => $q->where('name', RoleEnum::Admin->value));
    }

    /**
     * Halaman ini hanya mengelola akun berperan Admin (bukan super, agen, atau pencari properti).
     */
    private function pastikanAdmin(User $user): void
    {
        abort_unless($user->roleEnum() === RoleEnum::Admin, 404);
    }
}
