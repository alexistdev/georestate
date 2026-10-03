<?php

namespace App\Http\Controllers\Admin\Master;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Kelola pencari properti (role user): daftar, hapus, pulihkan.
 */
class UserController extends Controller
{
    public function index(Request $request)
    {
        $terhapus = $request->query('tab') === 'terhapus';
        $kata = $request->query('q');
        $kata = is_string($kata) && trim($kata) !== '' ? Str::limit(trim($kata), 100, '') : null;

        $users = $this->pencari($terhapus)
            ->when($kata, fn (Builder $q) => $q->where(
                fn (Builder $q) => $q->where('name', 'like', "%{$kata}%")->orWhere('email', 'like', "%{$kata}%")
            ))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.user', array(
            'judul' => "Kelola Pencari Properti | GeoRestate v.1.0",
            'menuUtama' => 'pengguna',
            'menuKedua' => 'user',
            'dataUsers' => $users,
            'terhapus' => $terhapus,
            'kata' => $kata,
            'jumlahAktif' => $this->pencari(false)->count(),
            'jumlahTerhapus' => $this->pencari(true)->count(),
        ));
    }

    public function resetPassword(ResetPasswordRequest $request, User $user)
    {
        $this->pastikanPencari($user);
        $user->update(['password' => Hash::make($request->validated('password'))]);

        return redirect(route('adm.user'))->with(['success' => "Password {$user->email} berhasil direset. Sampaikan password baru ke pengguna."]);
    }

    public function destroy(User $user)
    {
        $this->pastikanPencari($user);
        $user->delete();

        return redirect(route('adm.user'))->with(['delete' => "Akun {$user->email} dihapus. Data masih bisa dipulihkan dari tab Terhapus."]);
    }

    public function restore(User $user)
    {
        $this->pastikanPencari($user);
        abort_unless($user->trashed(), 404);
        $user->restore();

        return redirect(route('adm.user', ['tab' => 'terhapus']))->with(['success' => "Akun {$user->email} berhasil dipulihkan."]);
    }

    private function pencari(bool $terhapus): Builder
    {
        return User::query()
            ->when($terhapus, fn (Builder $q) => $q->onlyTrashed())
            ->whereHas('role', fn (Builder $q) => $q->where('name', Role::User->value));
    }

    /**
     * Halaman ini hanya untuk pencari properti; akun admin/agen dikelola di tempat lain.
     */
    private function pastikanPencari(User $user): void
    {
        abort_unless($user->roleEnum() === Role::User, 404);
    }
}
