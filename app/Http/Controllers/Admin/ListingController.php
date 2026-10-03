<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PropertyStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RejectListingRequest;
use App\Models\Property;
use App\Services\Admin\ModerasiService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Moderasi listing agen: setujui atau tolak sebelum tayang di website.
 */
class ListingController extends Controller
{
    public function __construct(private readonly ModerasiService $moderasiService)
    {
    }

    public function index(Request $request)
    {
        $status = PropertyStatus::tryFrom((string) $request->query('status')) ?? PropertyStatus::Pending;
        $kata = $request->query('q');
        $kata = is_string($kata) && trim($kata) !== '' ? Str::limit(trim($kata), 100, '') : null;

        $listings = Property::where('status', $status)
            ->when($kata, fn ($q) => $q->where('name', 'like', "%{$kata}%"))
            ->with('kecamatan', 'kategori', 'gambarUtama', 'agent.hasUser')
            // Antrean pending: yang paling lama menunggu di atas.
            ->when($status === PropertyStatus::Pending, fn ($q) => $q->oldest('updated_at'), fn ($q) => $q->latest('updated_at'))
            ->paginate(15)
            ->withQueryString();

        $jumlah = Property::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('admin.listing', array(
            'judul' => "Moderasi Listing | GeoRestate v.1.0",
            'menuUtama' => 'listing',
            'menuKedua' => 'listing',
            'dataListing' => $listings,
            'status' => $status,
            'kata' => $kata,
            'jumlah' => $jumlah,
        ));
    }

    public function show(Property $property)
    {
        $property->load('kecamatan', 'kategori', 'fasilitas', 'gambars', 'agent.hasUser');

        return view('admin.showlisting', array(
            'judul' => "Detail Listing | GeoRestate v.1.0",
            'menuUtama' => 'listing',
            'menuKedua' => 'listing',
            'property' => $property,
        ));
    }

    public function approve(Property $property)
    {
        $this->moderasiService->approve($property);

        return redirect($this->kembali())
            ->with(['success' => "Listing \"".$property->name."\" disetujui dan sekarang tayang di website."]);
    }

    public function reject(RejectListingRequest $request, Property $property)
    {
        $this->moderasiService->reject($property, $request->validated('alasan_penolakan'));

        return redirect($this->kembali())
            ->with(['success' => "Listing \"".$property->name."\" ditolak. Agen dapat melihat alasan penolakan."]);
    }

    /**
     * Setelah memproses listing, kembali ke antrean pending berikutnya.
     */
    private function kembali(): string
    {
        return route('adm.listing', ['status' => PropertyStatus::Pending->value]);
    }
}
