<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Fitur teks bebas (features) digantikan master fasilitas.
     */
    public function up(): void
    {
        Schema::dropIfExists('features');
    }

    public function down(): void
    {
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('property_id')
                ->constrained('properties')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });
    }
};
