<x-admin.admin-template>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Dashboard Super Administrator</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Selamat datang, {{ auth()->user()->name }}</h5>
                    <p class="text-muted mb-0">Area Super Administrator masih dalam pengembangan.</p>
                </div>
            </div>
        </div>
    </div>
</x-admin.admin-template>
