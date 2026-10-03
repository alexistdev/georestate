<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Semua pertanyaan calon penyewa (admin hanya melihat & menghapus spam, tidak membalas).
 */
class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $kata = $request->query('q');
        $kata = is_string($kata) && trim($kata) !== '' ? Str::limit(trim($kata), 100, '') : null;

        $pertanyaan = Inquiry::with('property', 'agent.hasUser')
            ->when($kata, fn (Builder $q) => $q->where(fn (Builder $q) => $q
                ->where('name', 'like', "%{$kata}%")
                ->orWhere('email', 'like', "%{$kata}%")
                ->orWhere('message', 'like', "%{$kata}%")))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.pertanyaan', array(
            'judul' => "Pertanyaan ke Agen | GeoRestate v.1.0",
            'menuUtama' => 'pertanyaan',
            'menuKedua' => 'pertanyaan',
            'dataPertanyaan' => $pertanyaan,
            'kata' => $kata,
        ));
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return redirect(route('adm.pertanyaan'))->with(['delete' => "Pertanyaan dari {$inquiry->email} dihapus."]);
    }
}
