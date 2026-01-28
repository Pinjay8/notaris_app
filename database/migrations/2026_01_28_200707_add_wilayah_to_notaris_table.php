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
        Schema::table('notaris', function (Blueprint $table) {
            $table->string('provinsi_id', 10)->nullable()->after('address');
            $table->string('provinsi_name')->nullable()->after('provinsi_id');

            $table->string('kota_id', 10)->nullable()->after('provinsi_name');
            $table->string('kota_name')->nullable()->after('kota_id');

            $table->string('kecamatan_id', 10)->nullable()->after('kota_name');
            $table->string('kecamatan_name')->nullable()->after('kecamatan_id');

            $table->string('kelurahan_id', 10)->nullable()->after('kecamatan_name');
            $table->string('kelurahan_name')->nullable()->after('kelurahan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notaris', function (Blueprint $table) {
            $table->dropColumn([
                'provinsi_id',
                'provinsi_name',
                'kota_id',
                'kota_name',
                'kecamatan_id',
                'kecamatan_name',
                'kelurahan_id',
                'kelurahan_name',
            ]);
        });
    }
};
