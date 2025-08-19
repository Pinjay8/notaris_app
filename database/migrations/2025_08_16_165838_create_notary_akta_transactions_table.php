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
        Schema::create('notary_akta_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notaris_id')->constrained('notaris');
            $table->foreignId('client_id')->constrained('clients');
            $table->foreignId('akta_type_id')->constrained('notary_akta_types');
            $table->string('registration_code')->nullable();
            $table->string('year')->nullable();
            $table->string('akta_number')->nullable();
            $table->string('akta_number_created_at')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('date_submission')->nullable();
            $table->dateTime('date_finished')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notary_akta_transactions');
    }
};
