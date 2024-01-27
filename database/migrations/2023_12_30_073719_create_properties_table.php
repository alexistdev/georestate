<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->foreignId('kecamatan_id')
                ->constrained('kecamatans')
                ->nullable();
            $table->foreignId('kategori_id')
                ->constrained('kategoris')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('beds')->default(0);
            $table->tinyInteger('baths')->default(0);
            $table->integer('lb')->default(0);
            $table->integer('lt')->default(0);
            $table->bigInteger('price')->default(0);
            $table->tinyInteger('isPremium')->default(0);
            $table->tinyInteger('isStatus')->default(1);
            $table->date('isPremium_expired')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
