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
        Schema::create('agents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('member_identifier')->unique();
            $table->string('phone')->nullable();
            $table->integer('provinsi_id')->unsigned()->nullable();
            $table->integer('kabupaten_id')->unsigned()->nullable();
            $table->integer('kecamatan_id')->unsigned()->nullable();
            $table->integer('kelurahan_id')->unsigned()->nullable();
            $table->string('alamat')->nullable();
            $table->boolean('isSuspend')->default(false);
            $table->tinyInteger('level')->default(4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
