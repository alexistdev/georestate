<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NamaMasterRequest;
use App\Rules\NamaUnik;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * Dasar halaman kelola master data berbasis nama (kategori, fasilitas):
 * daftar + jumlah listing pemakai, tambah, ubah, hapus (soft delete), pulihkan.
 * Data yang dihapus tidak bisa dipilih lagi, tapi listing lama tetap menampilkannya.
 */
abstract class MasterNamaController extends Controller
{
    /** @return class-string<Model> */
    abstract protected function model(): string;

    /**
     * @return array{judul: string, route: string, label: string, contoh: string, menuKedua: string}
     */
    abstract protected function info(): array;

    public function index(Request $request)
    {
        $info = $this->info();
        $terhapus = $request->query('tab') === 'terhapus';
        $kata = $request->query('q');
        $kata = is_string($kata) && trim($kata) !== '' ? Str::limit(trim($kata), 100, '') : null;

        $data = $this->query($terhapus)
            ->withCount('properties')
            ->when($kata, fn (Builder $q) => $q->where('name', 'like', "%{$kata}%"))
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('admin.master-nama', array(
            'judul' => "Kelola {$info['judul']} | GeoRestate v.1.0",
            'menuUtama' => 'master',
            'menuKedua' => $info['menuKedua'],
            'info' => $info,
            'dataMaster' => $data,
            'terhapus' => $terhapus,
            'kata' => $kata,
            'jumlahAktif' => $this->query(false)->count(),
            'jumlahTerhapus' => $this->query(true)->count(),
        ));
    }

    public function store(NamaMasterRequest $request)
    {
        $model = $this->model()::create(['name' => $request->validated('name')]);

        return redirect(route($this->info()['route']))
            ->with(['success' => "{$this->info()['label']} \"{$model->name}\" berhasil ditambahkan."]);
    }

    public function update(NamaMasterRequest $request, int $id)
    {
        $model = $this->model()::findOrFail($id);
        $model->update(['name' => $request->validated('name')]);

        return redirect(route($this->info()['route']))
            ->with(['success' => "{$this->info()['label']} berhasil diubah menjadi \"{$model->name}\"."]);
    }

    public function destroy(int $id)
    {
        $model = $this->model()::findOrFail($id);
        $model->delete();

        return redirect(route($this->info()['route']))
            ->with(['delete' => "{$this->info()['label']} \"{$model->name}\" dihapus. Listing lama tetap menampilkannya, tapi tidak bisa dipilih lagi."]);
    }

    public function restore(int $id)
    {
        $model = $this->model()::onlyTrashed()->findOrFail($id);

        // Jangan pulihkan jika sudah ada data aktif dengan nama yang sama.
        Validator::make(['name' => $model->name], ['name' => [new NamaUnik($model->getTable())]])->validate();

        $model->restore();

        return redirect(route($this->info()['route'], ['tab' => 'terhapus']))
            ->with(['success' => "{$this->info()['label']} \"{$model->name}\" berhasil dipulihkan."]);
    }

    private function query(bool $terhapus): Builder
    {
        return $terhapus ? $this->model()::onlyTrashed() : $this->model()::query();
    }
}
