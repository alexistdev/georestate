<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Master fasilitas (AC, WiFi, parkir, ...) dan relasinya ke properti.
     */
    public function up(): void
    {
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('fasilitas_property', function (Blueprint $table) {
            $table->foreignId('fasilitas_id')
                ->constrained('fasilitas')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignUuid('property_id')
                ->constrained('properties')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->primary(['fasilitas_id', 'property_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas_property');
        Schema::dropIfExists('fasilitas');
    }
};
