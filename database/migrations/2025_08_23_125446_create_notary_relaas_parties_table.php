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
        Schema::create('notary_relaas_parties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notaris_id')->constrained('notaris');
            $table->foreignId('client_id')->constrained('clients');
            $table->string('registration_code')->nullable();
            $table->foreignId('relaas_id')
                ->constrained('notary_relaas_aktas');
            $table->string('name')->nullable();
            $table->string('role')->nullable();
            $table->string('address')->nullable();
            $table->string('id_number')->nullable();
            $table->string('id_type')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notary_relaas_parties');
    }
};
