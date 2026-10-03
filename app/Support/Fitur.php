<?php

namespace App\Support;

/**
 * Penanda fitur yang bergantung pada konfigurasi server.
 */
class Fitur
{
    /**
     * Email dianggap aktif jika mailer bukan `log`/`array` (yang tidak benar-benar mengirim email).
     * Selama belum aktif, fitur "Lupa password" disembunyikan dan admin mereset password dari panel.
     */
    public static function emailAktif(): bool
    {
        return ! in_array(config('mail.default'), ['log', 'array'], true);
    }
}
