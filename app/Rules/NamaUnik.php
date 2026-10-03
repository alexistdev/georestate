<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

/**
 * Nama harus unik di antara data yang belum dihapus, tanpa membedakan huruf besar/kecil
 * ("Rumah" dan "rumah" dianggap sama).
 */
class NamaUnik implements ValidationRule
{
    public function __construct(private string $table, private ?int $abaikanId = null)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $sudahAda = DB::table($this->table)
            ->whereNull('deleted_at')
            ->whereRaw('LOWER(name) = ?', [mb_strtolower(trim((string) $value))])
            ->when($this->abaikanId, fn ($q, $id) => $q->where('id', '!=', $id))
            ->exists();

        if ($sudahAda) {
            $fail("Nama \"{$value}\" sudah ada.");
        }
    }
}
