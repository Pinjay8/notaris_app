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
        Schema::create('notary_waarmerkings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notaris_id')->constrained('notaris');
            $table->foreignId('client_id')->constrained('clients');
            $table->string('waarmerking_number')->nullable();
            $table->string('applicant_name')->nullable();
            $table->string('officer_name')->nullable();
            $table->string('document_type')->nullable();
            $table->string('document_number')->nullable();
            $table->date('request_date')->nullable();
            $table->date('release_date')->nullable();
            $table->text('notes')->nullable();
            $table->longText('file_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notary_waarmerkings');
    }
};
