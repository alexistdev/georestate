<x-front.front-end-template :title="$judul" :main-label="$menuUtama" :secondary-label="$menuKedua">
    @include('front.akun.partials.layout', ['judulHalaman' => 'Riwayat Pertanyaan'])

    <div class="container py-5 my-3">
        <div class="row">
            <div class="col-lg-3">
                @include('front.akun.partials.menu')
            </div>
            <div class="col-lg-9">
                @forelse($dataPertanyaan as $tanya)
                    @php($listing = $tanya->property)
                    <div class="card custom-card-info custom-card-info-shadow border-0 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex flex-wrap align-items-start gap-2 mb-2">
                                <div class="flex-grow-1">
                                    @if($listing && $listing->status === \App\Enums\PropertyStatus::Approved && !$listing->trashed())
                                        <a href="{{ route('front.properties.detail', $listing->slug) }}" class="text-dark font-weight-semibold text-4">{{ $listing->name }}</a>
                                    @else
                                        <span class="text-dark font-weight-semibold text-4">{{ $listing->name ?? 'Properti tidak tersedia' }}</span>
                                        <span class="text-2 d-block">Properti ini sudah tidak tayang.</span>
                                    @endif
                                    <span class="d-block text-2">Agen: {{ $tanya->agent?->hasUser?->name ?? '-' }} · {{ $tanya->created_at?->format('d-m-Y H:i') }}</span>
                                </div>
                                <span class="badge bg-{{ $tanya->status->badge() }} text-1 px-3 py-2">{{ $tanya->status->label() }}</span>
                            </div>
                            <p class="mb-0" style="white-space: pre-line;">{{ $tanya->message }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="far fa-comments text-color-secondary text-10 d-block mb-3"></i>
                        <h3 class="text-5 mb-2">Belum ada pertanyaan</h3>
                        <p class="mb-3">Pertanyaan yang Anda kirim lewat form "Tanya Agen" saat login akan tampil di sini.</p>
                        <a href="{{ route('front.properties') }}" class="btn btn-secondary btn-px-4">Cari Properti</a>
                    </div>
                @endforelse

                @if($dataPertanyaan->hasPages())
                    <div class="d-flex pt-3 justify-content-center">
                        {{ $dataPertanyaan->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-front.front-end-template>
