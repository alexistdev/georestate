<x-front.front-end-template :title="$judul" :main-label="$menuUtama" :secondary-label="$menuKedua">
    @include('front.akun.partials.layout', ['judulHalaman' => 'Favorit Saya'])

    <div class="container py-5 my-3">
        <div class="row">
            <div class="col-lg-3">
                @include('front.akun.partials.menu')
            </div>
            <div class="col-lg-9">
                <div class="row">
                    @forelse($dataProperties as $property)
                        <div class="col-12 col-sm-6 col-lg-4 pb-4 mb-1">
                            @include('front.partials.property-card', ['property' => $property, 'periode' => null])
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="far fa-heart text-color-secondary text-10 d-block mb-3"></i>
                            <h3 class="text-5 mb-2">Belum ada properti favorit</h3>
                            <p class="mb-3">Tekan ikon ❤ pada properti yang Anda sukai untuk menyimpannya di sini.</p>
                            <a href="{{ route('front.properties') }}" class="btn btn-secondary btn-px-4">Cari Properti</a>
                        </div>
                    @endforelse
                </div>
                @if($dataProperties->hasPages())
                    <div class="d-flex pt-3 justify-content-center">
                        {{ $dataProperties->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-front.front-end-template>
