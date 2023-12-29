<div>
    <!-- START: Modal TAMBAH PROVINSI-->
    <div class="modal fade" id="tambahProvinsi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{route('adm.disctrict.provinsi.save')}}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Provinsi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label
                                    for="provinsiName" @class(["form-label"]) >NAME</label>
                                <input type="text" name="name" maxlength="255"
                                       @class(["form-control"]) style="text-transform:uppercase"
                                       value="{{old('name')}}" placeholder="Masukkan Nama Provinsi"
                                       id="provinsiName" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modal EDIT TAMBAH-->

    <!-- START: Modal EDIT PROVINSI-->
    <div class="modal fade" id="editProvinsi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{route('adm.disctrict.provinsi.update')}}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Provinsi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="editProvinsiId" class="hidden"></label>
                                <input type="hidden" name="provinsi_id" class="form-control"
                                       value="{{old('provinsi_id')}}"
                                       id="editProvinsiId">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label
                                    for="editProvinsiName" @class(["form-label"]) >NAME</label>
                                <input type="text" name="name" maxlength="125"
                                       @class(["form-control"]) style="text-transform:uppercase"
                                       value="{{old('name')}}"
                                       id="editProvinsiName">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modal EDIT PROVINSI-->

    <!-- START: Modal HAPUS PROVINSI-->
    <div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{route('adm.disctrict.provinsi.delete')}}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Provinsi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <input type="hidden" name="provinsi_id" class="form-control"
                                       value="{{old('provinsi_id')}}"
                                       id="hapusProvinsiId">
                                Apa anda ingin menghapus data Provinsi ini?
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modal HAPUS PROVINSI-->

    <!-- START: Modal TAMBAH KABUPATEN-->
    <div class="modal fade modalEditAll" id="tambahKabupaten" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{route('adm.disctrict.kabupaten.save')}}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">TAMBAH KABUPATEN</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="provinsiNamex">PROVINSI</label>
                                <select id="provinsiNamex" class="form-control" name="provinsi_id">
                                    @foreach($dataProvinsi as $prov)
                                        <option
                                            value="{{base64_encode($prov->id)}}">{{$prov->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label
                                    for="kabupatenName" @class(["form-label"]) >NAME</label>
                                <input type="text" name="name" maxlength="255"
                                       @class(["form-control"]) style="text-transform:uppercase"
                                       value="{{old('name')}}" placeholder="Masukkan Nama Kabupaten"
                                       id="kabupatenName" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modal TAMBAH KABUPATEN-->

    <!-- START: Modal EDIT KABUPATEN-->
    <div class="modal fade modalEditAll" id="editKabupaten" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{route('adm.disctrict.kabupaten.update')}}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">EDIT DATA KABUPATEN</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="hidden" name="kabupaten_id" id="kabupaten_id"
                                       value="{{old('kabupaten_id')}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="provinsiNamey">PROVINSI</label>
                                <select id="provinsiNamey" class="editSelectedProvinsi form-control" name="provinsi_id">
                                    @foreach($dataProvinsi as $prov)
                                        <option
                                            value="{{base64_encode($prov->id)}}">{{$prov->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label
                                    for="kabupatenNameEdit" @class(["form-label"]) >NAME</label>
                                <input type="text" name="name" maxlength="255"
                                       @class(["form-control"]) style="text-transform:uppercase"
                                       value="{{old('name')}}" placeholder="Masukkan Nama Kabupaten"
                                       id="kabupatenNameEdit" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modal EDIT KABUPATEN-->

    <!-- START: Modal HAPUS KABUPATEN-->
    <div class="modal fade" id="modalHapusKabupaten" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{route('adm.disctrict.kabupaten.delete')}}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">HAPUS KABUPATEN</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <input type="hidden" name="kabupaten_id" class="form-control"
                                       value="{{old('kabupaten_id')}}"
                                       id="hapusKabupatenId">
                                Apa anda ingin menghapus data Kabupaten ini?
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modal HAPUS KABUPATEN-->

    <!-- START: Modal TAMBAH KECAMATAN-->
    <div class="modal fade modalEditAll" id="tambahKecamatan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{route('adm.disctrict.kecamatan.save')}}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">TAMBAH KECAMATAN</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="kecamatanNameX">KABUPATEN</label>
                                <select id="kecamatanNameX" class="form-control" name="kabupaten_id">
                                    @foreach($dataKabupaten as $kab)
                                        <option
                                            value="{{base64_encode($kab->id)}}">{{$kab->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label
                                    for="kecamatanName" @class(["form-label"]) >NAME</label>
                                <input type="text" name="name" maxlength="255"
                                       @class(["form-control"]) style="text-transform:uppercase"
                                       value="{{old('name')}}" placeholder="Masukkan Nama Kecamatan"
                                       id="kecamatanName" >
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modal TAMBAH KECAMATAN-->

    <!-- START: Modal EDIT KECAMATAN-->
    <div class="modal fade modalEditAll" id="editKecamatan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{route('adm.disctrict.kecamatan.update')}}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">EDIT DATA KECAMATAN</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="hidden" name="kecamatan_id" id="kecamatan_id"
                                       value="{{old('kecamatan_id')}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="kabupatenNamey">KABUPATEN</label>
                                <select id="kabupatenNamey" class="editSelectedProvinsi form-control" name="kabupaten_id">
                                    @foreach($dataKabupaten as $kab)
                                        <option
                                            value="{{base64_encode($kab->id)}}">{{$kab->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label
                                    for="kecamatanNameEdit" @class(["form-label"]) >NAME</label>
                                <input type="text" name="name" maxlength="255"
                                       @class(["form-control"]) style="text-transform:uppercase"
                                       value="{{old('name')}}" placeholder="Masukkan Nama Kecamatan"
                                       id="kecamatanNameEdit" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modal EDIT KECAMATAN-->

    <!-- START: Modal HAPUS KECAMATAN-->
    <div class="modal fade" id="modalHapusKecamatan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{route('adm.disctrict.kecamatan.delete')}}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">HAPUS KECAMATAN</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <input type="hidden" name="kecamatan_id" class="form-control"
                                       value="{{old('kecamatan_id')}}"
                                       id="hapusKecamatanId">
                                Apa anda ingin menghapus data Kecamatan ini?
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modal HAPUS KECAMATAN-->
</div>
