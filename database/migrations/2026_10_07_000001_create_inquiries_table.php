<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pertanyaan calon penyewa ke agen dari halaman detail properti.
     */
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('property_id')->constrained('properties')->cascadeOnUpdate()->cascadeOnDelete();
            // Disimpan langsung agar kotak masuk agen cepat & tetap benar walau listing berpindah.
            $table->foreignUuid('agent_id')->constrained('agents')->cascadeOnUpdate()->cascadeOnDelete();
            // Terisi jika penanya sedang login (untuk riwayat pertanyaan).
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 30)->nullable();
            $table->text('message');
            $table->string('status', 20)->default('baru')->index();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
