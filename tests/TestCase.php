<?php

namespace Tests;

use App\Services\GeoLicense\LicenseHolder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Http;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // Halaman Breeze memakai @vite; test tidak butuh hasil `npm run build`.
        $this->withoutVite();

        // Test tidak boleh menghubungi server lisensi (atau layanan luar lain) sungguhan.
        Http::preventStrayRequests();

        // Anggap lisensi valid selama test; perilaku lisensi diuji di tests/Feature/LicenseTest.php.
        $license = app(LicenseHolder::class);
        $license->setToken('test-token');
        $license->setValid(true);
    }
}
