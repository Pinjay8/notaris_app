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
        Schema::create('notary_akta_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notaris_id')->constrained('notaris');
            $table->string('client_code', 50)->nullable();

            $table->foreign('client_code')
                ->references('client_code')
                ->on('clients')
                ->onDelete('set null');

            $table->foreignId('akta_transaction_id')->constrained('notary_akta_transactions');
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_url')->nullable();
            $table->string('file_type')->nullable();
            $table->dateTime('uploaded_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notary_akta_documents');
    }
};
