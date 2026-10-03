<x-agent.agent-template :title="$title" :menu-utama="$menuUtama" :menu-kedua="$menuKedua">
    @php
        $user = auth()->user();
        $kecamatan = $agent->kecamatan;
        $provinsiAwal = old('provinsi', $kecamatan?->kabupaten?->provinsi_id);
        $kabupatenAwal = old('kabupaten', $kecamatan?->kabupaten_id);
        $kecamatanAwal = old('kecamatan', $kecamatan?->id);
    @endphp
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Profil Saya</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('agn.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Profil Saya</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('status') === 'password-updated')
        <div class="alert alert-success">Password berhasil diubah.</div>
    @endif

    <form method="POST" action="{{ route('agn.profil.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Foto Profil</h5></div>
                    <div class="card-body text-center">
                        <img id="pratinjauFoto" src="{{ $agent->fotoUrl() }}" alt="Foto profil"
                             class="rounded-circle mb-3" style="width: 140px; height: 140px; object-fit: cover;"
                             onerror="this.onerror=null;this.src='{{ asset(\App\Models\Agent::FOTO_DEFAULT) }}'">
                        <input type="file" name="foto" id="foto" accept="image/jpeg,image/png,image/webp"
                               class="form-control @error('foto') is-invalid @enderror">
                        @error('foto')<div class="invalid-feedback text-start">{{ $message }}</div>@enderror
                        <div class="form-text text-start">JPG/PNG/WebP, maksimal 2 MB. Foto dipotong otomatis di bagian tengah.</div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <p class="text-muted small mb-2">Profil ini tampil di halaman publik agen dan di setiap listing Anda.</p>
                        <a href="{{ route('front.agents.detail', $agent) }}" target="_blank" rel="noopener" class="btn btn-soft-primary btn-sm w-100">
                            <i class="ri-external-link-line align-bottom"></i> Lihat Profil Publik
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Data Diri</h5></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" maxlength="100" required
                                       value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Telepon / WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" name="phone" id="phone" maxlength="20" required placeholder="081234567890"
                                       value="{{ old('phone', $agent->phone) }}" class="form-control @error('phone') is-invalid @enderror">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Kantor / Domisili</label>
                            <input type="text" name="alamat" id="alamat" maxlength="255"
                                   value="{{ old('alamat', $agent->alamat) }}" class="form-control @error('alamat') is-invalid @enderror">
                            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="profilProvinsi" class="form-label">Provinsi</label>
                                <select name="provinsi" id="profilProvinsi" class="form-select">
                                    <option value="">=Pilih=</option>
                                    @foreach($dataProvinsi as $provinsi)
                                        <option value="{{ $provinsi->id }}" @selected($provinsi->id == $provinsiAwal)>{{ $provinsi->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="profilKabupaten" class="form-label">Kabupaten/Kota</label>
                                <select name="kabupaten" id="profilKabupaten" class="form-select">
                                    <option value="">=Pilih=</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="profilKecamatan" class="form-label">Kecamatan</label>
                                <select name="kecamatan" id="profilKecamatan" class="form-select @error('kecamatan') is-invalid @enderror">
                                    <option value="">=Pilih=</option>
                                </select>
                                @error('kecamatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="about" class="form-label">Tentang Saya</label>
                            <textarea name="about" id="about" rows="5" maxlength="2000"
                                      placeholder="Ceritakan pengalaman Anda sebagai agen, wilayah yang Anda layani, dan jenis properti yang Anda tawarkan."
                                      class="form-control @error('about') is-invalid @enderror">{{ old('about', $agent->about) }}</textarea>
                            @error('about')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Simpan Profil</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-xl-6" id="ganti-email">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Ganti Email Login</h5></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('agn.profil.email') }}">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" maxlength="255" required
                                   value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="email_current_password" class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                            <input type="password" name="current_password" id="email_current_password" required autocomplete="current-password"
                                   class="form-control @error('current_password') is-invalid @enderror">
                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Email</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-6" id="ubah-password">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Ubah Password</h5></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                            <input type="password" name="current_password" id="current_password" required autocomplete="current-password"
                                   class="form-control @error('current_password', 'updatePassword') is-invalid @enderror">
                            @error('current_password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" required autocomplete="new-password"
                                   class="form-control @error('password', 'updatePassword') is-invalid @enderror">
                            @error('password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">Minimal 8 karakter.</div>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Ulangi Password Baru <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('customJS')
        <script>
            (function () {
                const provinsi = document.getElementById('profilProvinsi');
                const kabupaten = document.getElementById('profilKabupaten');
                const kecamatan = document.getElementById('profilKecamatan');
                const urlKabupaten = @json(route('front.wilayah.kabupaten', '__ID__'));
                const urlKecamatan = @json(route('front.wilayah.kecamatan', '__ID__'));
                const awalKabupaten = @json($kabupatenAwal);
                const awalKecamatan = @json($kecamatanAwal);

                function isi(select, url, terpilih) {
                    select.length = 1;
                    return fetch(url, {headers: {'Accept': 'application/json'}})
                        .then(r => r.ok ? r.json() : [])
                        .then(data => data.forEach(item => {
                            const pilih = terpilih !== null && String(item.id) === String(terpilih);
                            select.add(new Option(item.name, item.id, pilih, pilih));
                        }));
                }

                provinsi.addEventListener('change', function () {
                    kecamatan.length = 1;
                    kabupaten.length = 1;
                    if (this.value) {
                        isi(kabupaten, urlKabupaten.replace('__ID__', this.value), null);
                    }
                });
                kabupaten.addEventListener('change', function () {
                    kecamatan.length = 1;
                    if (this.value) {
                        isi(kecamatan, urlKecamatan.replace('__ID__', this.value), null);
                    }
                });

                // Isi ulang pilihan wilayah yang sudah tersimpan / dari isian sebelumnya.
                if (provinsi.value) {
                    isi(kabupaten, urlKabupaten.replace('__ID__', provinsi.value), awalKabupaten).then(function () {
                        if (awalKabupaten) {
                            isi(kecamatan, urlKecamatan.replace('__ID__', awalKabupaten), awalKecamatan);
                        }
                    });
                }

                // Pratinjau foto sebelum diupload.
                document.getElementById('foto').addEventListener('change', function () {
                    if (this.files[0]) {
                        document.getElementById('pratinjauFoto').src = URL.createObjectURL(this.files[0]);
                    }
                });
            })();
        </script>
    @endpush
</x-agent.agent-template>
