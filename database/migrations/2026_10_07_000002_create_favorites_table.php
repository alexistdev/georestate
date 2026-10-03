<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Properti favorit pencari properti.
     */
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('property_id')->constrained('properties')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
            $table->primary(['user_id', 'property_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
