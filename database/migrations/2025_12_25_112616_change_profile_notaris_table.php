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
            $table->text('sk_ppat')->nullable();
            $table->date('sk_ppat_date')->nullable();
            $table->text('sk_notaris')->nullable();
            $table->date('sk_notaris_date')->nullable();
            $table->text('no_kta_ini')->nullable();
            $table->text('no_kta_ippat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
