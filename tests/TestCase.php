<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // Halaman Breeze memakai @vite; test tidak butuh hasil `npm run build`.
        $this->withoutVite();
    }
}
