<x-agent.agent-template :title="$title" :menu-utama="$menuUtama" :menu-kedua="$menuKedua">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">My Listing Properties</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('agn.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">My Listing Properties</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('delete'))
        <div class="alert alert-warning">{{ session('delete') }}</div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Daftar Listing</h5>
                    <a href="{{ route('agn.lists.add') }}" class="btn btn-info"><i class="ri-add-fill me-1 align-bottom"></i> Tambah Listing</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap mb-0">
                            <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 80px;">Foto</th>
                                <th scope="col">Nama Property</th>
                                <th scope="col">Harga Sewa</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($dataList as $list)
                                <tr>
                                    <td>
                                        <img src="{{ $list->gambarUtamaUrl() }}" alt="" class="rounded" style="width:64px;height:48px;object-fit:cover"
                                             onerror="this.onerror=null;this.src='{{ \App\Models\Gambar::defaultUrl() }}'">
                                    </td>
                                    <td>
                                        <a href="{{ route('agn.lists.show', $list) }}" class="fw-medium">{{ $list->name }}</a>
                                    </td>
                                    <td>
                                        @foreach($list->daftarHarga() as $periode => $harga)
                                            <div>{{ $harga }} <span class="text-muted">/ {{ $periode }}</span></div>
                                        @endforeach
                                    </td>
                                    <td>{{ $list->kategori->name ?? '-' }}</td>
                                    <td class="text-wrap" style="min-width: 180px">{{ $list->lokasi() ?: '-' }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $list->status->badge() }}">{{ $list->status->label() }}</span>
                                    </td>
                                    <td>
                                        <div class="hstack gap-2 justify-content-center">
                                            <a href="{{ route('agn.lists.show', $list) }}" class="btn btn-sm btn-soft-info" title="Detail"><i class="ri-eye-fill align-bottom"></i></a>
                                            <a href="{{ route('agn.lists.edit', $list) }}" class="btn btn-sm btn-soft-primary" title="Edit"><i class="ri-pencil-fill align-bottom"></i></a>
                                            <button type="button" class="btn btn-sm btn-soft-danger open-hapus-listing" title="Hapus"
                                                    data-bs-toggle="modal" data-bs-target="#modalHapusListing"
                                                    data-action="{{ route('agn.lists.delete', $list) }}" data-name="{{ $list->name }}">
                                                <i class="ri-delete-bin-fill align-bottom"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Belum ada listing. <a href="{{ route('agn.lists.add') }}">Tambah listing pertama Anda</a>.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 gap-2">
                        <div class="text-muted">Total data: {{ $dataList->total() }}</div>
                        {{ $dataList->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('agen.partials.hapus-listing-modal')
</x-agent.agent-template>
