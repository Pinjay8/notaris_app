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
            $table->foreignId('client_id')->nullable()->constrained('clients');
            $table->string('registration_code')->nullable();
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
