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
        Schema::create('notary_consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notaris_id')->nullable()->constrained('notaris');
            // 1️⃣ Buat dulu kolom string
            $table->string('client_code', 50)->nullable();

            // 2️⃣ Baru bikin foreign key
            $table->foreign('client_code')
                ->references('client_code') // kolom di tabel clients
                ->on('clients')
                ->onDelete('set null');
            $table->string('subject')->nullable();
            $table->text('description')->nullable();
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notary_consultations');
    }
};
