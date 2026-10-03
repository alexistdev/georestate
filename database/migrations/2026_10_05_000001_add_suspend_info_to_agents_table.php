<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Alasan & waktu suspend agen (ditampilkan ke agen saat mencoba login).
     */
    public function up(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->text('alasan_suspend')->nullable()->after('isSuspend');
            $table->timestamp('suspended_at')->nullable()->after('alasan_suspend');
        });
    }

    public function down(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->dropColumn(['alasan_suspend', 'suspended_at']);
        });
    }
};
