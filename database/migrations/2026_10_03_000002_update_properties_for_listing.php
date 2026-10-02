<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Listing milik agen, status persetujuan admin, dan harga per periode sewa.
     */
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->foreignUuid('agent_id')
                ->nullable()
                ->after('id')
                ->constrained('agents')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('slug')->nullable()->unique()->after('name');
            $table->string('status', 20)->default('pending')->index()->after('description');
            $table->text('alasan_penolakan')->nullable()->after('status');
            $table->timestamp('approved_at')->nullable()->after('alasan_penolakan');
            $table->unsignedBigInteger('harga_harian')->nullable()->after('lt');
            $table->unsignedBigInteger('harga_bulanan')->nullable()->after('harga_harian');
            $table->unsignedBigInteger('harga_tahunan')->nullable()->after('harga_bulanan');
        });

        // Harga lama dianggap harga bulanan.
        DB::table('properties')->where('price', '>', 0)->update(['harga_bulanan' => DB::raw('price')]);

        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->bigInteger('price')->default(0)->after('lt');
        });

        DB::table('properties')->whereNotNull('harga_bulanan')->update(['price' => DB::raw('harga_bulanan')]);

        Schema::table('properties', function (Blueprint $table) {
            $table->dropConstrainedForeignId('agent_id');
            $table->dropUnique(['slug']);
            $table->dropIndex(['status']);
            $table->dropColumn([
                'slug', 'status', 'alasan_penolakan', 'approved_at',
                'harga_harian', 'harga_bulanan', 'harga_tahunan',
            ]);
        });
    }
};
