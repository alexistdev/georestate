{{--
    Daftar foto listing dengan tombol jadikan utama & hapus.
    Variabel: $property (dengan relasi gambars), $editable (bool)
--}}
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Foto ({{ $property->gambars->count() }}/{{ \App\Models\Property::MAX_GAMBAR }})</h5>
    </div>
    <div class="card-body">
        @error('foto')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="row g-3">
            @forelse($property->gambars as $gambar)
                <div class="col-6 col-md-4 col-xl-3">
                    <div class="border rounded p-1 h-100 d-flex flex-column">
                        <img src="{{ $gambar->url }}" alt="Foto {{ $property->name }}" class="img-fluid rounded"
                             style="height:140px;width:100%;object-fit:cover">
                        <div class="mt-2 d-flex gap-1 flex-wrap align-items-center">
                            @if($gambar->isDefault)
                                <span class="badge bg-primary">Foto Utama</span>
                            @elseif($editable)
                                <form method="post" action="{{ route('agn.lists.gambar.utama', [$property, $gambar]) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-soft-primary">Jadikan Utama</button>
                                </form>
                            @endif
                            @if($editable && $property->gambars->count() > 1)
                                <form method="post" action="{{ route('agn.lists.gambar.delete', [$property, $gambar]) }}"
                                      onsubmit="return confirm('Hapus foto ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-soft-danger"><i class="ri-delete-bin-line"></i></button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted mb-0">Belum ada foto.</p>
            @endforelse
        </div>
    </div>
</div>
