<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Kolom isStatus tidak pernah dipakai; status listing ada di kolom `status` (App\Enums\PropertyStatus).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('properties', 'isStatus')) {
            Schema::table('properties', function (Blueprint $table) {
                $table->dropColumn('isStatus');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('properties', 'isStatus')) {
            Schema::table('properties', function (Blueprint $table) {
                $table->tinyInteger('isStatus')->default(1)->after('isPremium');
            });
        }
    }
};
