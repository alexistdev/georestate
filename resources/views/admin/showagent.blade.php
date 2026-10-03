<x-admin.admin-template :title="$judul">
    @php($user = $agent->hasUser)
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Detail Agen</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('adm.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('adm.agent') }}">Agen</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.alert')

    @if($agent->trashed())
        <div class="alert alert-secondary d-flex flex-wrap align-items-center gap-2">
            <div class="flex-grow-1">Agen ini <strong>sudah dihapus</strong> pada {{ $agent->deleted_at?->format('d-m-Y H:i') }}. Akun tidak bisa login dan listing tidak tampil di website.</div>
            <form method="POST" action="{{ route('adm.agent.restore', $agent) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-sm btn-success">Pulihkan Agen</button>
            </form>
        </div>
    @elseif($agent->isSuspend)
        <div class="alert alert-danger">
            <strong>Agen disuspend</strong> sejak {{ $agent->suspended_at?->format('d-m-Y H:i') ?? '-' }}.
            Alasan: {{ $agent->alasan_suspend ?: '-' }}
        </div>
    @endif

    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ $agent->fotoUrl() }}" alt="" class="rounded-circle mb-3" style="width:96px;height:96px;object-fit:cover"
                         onerror="this.onerror=null;this.src='{{ asset(\App\Models\Agent::FOTO_DEFAULT) }}'">
                    <h5 class="mb-1">{{ $user->name ?? '(akun tidak ditemukan)' }}</h5>
                    <p class="text-muted mb-2">{{ $user->email ?? '-' }}</p>
                    @if($agent->trashed())
                        <span class="badge bg-secondary">Terhapus</span>
                    @elseif($agent->isSuspend)
                        <span class="badge bg-danger">Disuspend</span>
                    @else
                        <span class="badge bg-success">Aktif</span>
                    @endif
                </div>
                <div class="card-body border-top">
                    <table class="table table-sm table-borderless mb-0">
                        <tr><td class="text-muted">ID Agen</td><td class="text-break">{{ $agent->member_identifier }}</td></tr>
                        <tr><td class="text-muted">Telepon</td><td>{{ $agent->phone ?: '-' }}</td></tr>
                        <tr><td class="text-muted">Alamat</td><td>{{ $agent->alamat ?: '-' }}</td></tr>
                        <tr><td class="text-muted">Wilayah</td><td>{{ $agent->kecamatan ? $agent->kecamatan->name.', '.($agent->kecamatan->kabupaten->name ?? '') : '-' }}</td></tr>
                        <tr><td class="text-muted">Bergabung</td><td>{{ $agent->created_at?->format('d-m-Y') }}</td></tr>
                    </table>
                </div>
            </div>

            @unless($agent->trashed())
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Tindakan</h5></div>
                    <div class="card-body">
                        @if($agent->isSuspend)
                            <form method="POST" action="{{ route('adm.agent.aktifkan', $agent) }}" class="mb-3">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success w-100"><i class="ri-user-follow-line align-bottom"></i> Aktifkan Kembali</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('adm.agent.suspend', $agent) }}" class="mb-3">
                                @csrf
                                @method('PATCH')
                                <label for="alasan_suspend" class="form-label">Suspend agen — alasan <span class="text-danger">*</span></label>
                                <textarea name="alasan_suspend" id="alasan_suspend" rows="3" maxlength="500"
                                          class="form-control @error('alasan_suspend') is-invalid @enderror"
                                          placeholder="Alasan ini akan dilihat agen saat mencoba login.">{{ old('alasan_suspend') }}</textarea>
                                @error('alasan_suspend')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <button type="submit" class="btn btn-warning text-dark w-100 mt-2"><i class="ri-user-forbid-line align-bottom"></i> Suspend Agen</button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('adm.agent.password', $agent) }}" class="mb-3" autocomplete="off">
                            @csrf
                            @method('PATCH')
                            <label class="form-label">Reset password agen</label>
                            <input type="password" name="password" required autocomplete="new-password" placeholder="Password baru (min. 8 karakter)"
                                   class="form-control mb-2 @error('password') is-invalid @enderror">
                            @error('password')<div class="invalid-feedback mb-2">{{ $message }}</div>@enderror
                            <input type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password baru" class="form-control mb-2">
                            <button type="submit" class="btn btn-soft-info w-100"><i class="ri-lock-password-line align-bottom"></i> Reset Password</button>
                        </form>

                        <form method="POST" action="{{ route('adm.agent.delete', $agent) }}"
                              onsubmit="return confirm('Hapus agen ini? Akun tidak bisa login dan listing-nya hilang dari website. Data masih bisa dipulihkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-soft-danger w-100"><i class="ri-delete-bin-line align-bottom"></i> Hapus Agen</button>
                        </form>
                    </div>
                </div>
            @endunless
        </div>

        <div class="col-xl-8">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Listing ({{ $dataListing->count() }})</h5></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap mb-0">
                            <thead class="table-light">
                            <tr>
                                <th style="width: 72px;">Foto</th>
                                <th>Listing</th>
                                <th class="text-center">Status</th>
                                <th>Diperbarui</th>
                                <th class="text-end"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($dataListing as $listing)
                                <tr>
                                    <td>
                                        <img src="{{ $listing->gambarUtamaUrl() }}" alt="" class="rounded" style="width:56px;height:42px;object-fit:cover"
                                             onerror="this.onerror=null;this.src='{{ \App\Models\Gambar::defaultUrl() }}'">
                                    </td>
                                    <td>
                                        <div class="fw-medium">{{ \Illuminate\Support\Str::limit($listing->name, 45) }}</div>
                                        <div class="text-muted small">{{ $listing->kategori->name ?? '-' }}</div>
                                    </td>
                                    <td class="text-center"><span class="badge bg-{{ $listing->status->badge() }}">{{ $listing->status->label() }}</span></td>
                                    <td>{{ $listing->updated_at?->format('d-m-Y H:i') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('adm.listing.show', $listing) }}" class="btn btn-sm btn-soft-primary">Tinjau</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">Agen ini belum punya listing.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.admin-template>
