<x-agent.agent-template :title="$title" :menu-utama="$menuUtama" :menu-kedua="$menuKedua">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Listing</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('agn.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('agn.lists')}}">My Listing</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="alert alert-warning">
        Setelah disimpan, listing akan kembali berstatus <strong>Menunggu Persetujuan</strong> dan tidak tampil di website sampai disetujui admin.
    </div>

    @include('agen.partials.property-form', ['action' => route('agn.lists.update', $property)])

    @include('agen.partials.gambar-manager', ['editable' => true])
</x-agent.agent-template>
