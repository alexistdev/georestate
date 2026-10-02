{{--
    Modal konfirmasi hapus listing. Jika $property diberikan, form langsung mengarah ke listing tsb;
    jika tidak, action diisi lewat tombol ber-class `open-hapus-listing` dengan data-action.
--}}
<div class="modal fade" id="modalHapusListing" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" id="formHapusListing" action="{{ isset($property) ? route('agn.lists.delete', $property) : '' }}">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Listing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Yakin ingin menghapus listing <strong id="namaHapusListing">{{ $property->name ?? '' }}</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('click', function (e) {
        let tombol = e.target.closest('.open-hapus-listing');
        if (!tombol) {
            return;
        }
        document.getElementById('formHapusListing').action = tombol.dataset.action;
        document.getElementById('namaHapusListing').textContent = tombol.dataset.name;
    });
</script>
