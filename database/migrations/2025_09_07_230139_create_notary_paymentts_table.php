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
        Schema::create('notary_paymentts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notaris_id')->constrained('notaris')->onDelete('cascade');
            $table->string('client_code', 50)->nullable();

            $table->foreign('client_code')
                ->references('client_code')
                ->on('clients')
                ->onDelete('set null');

            $table->foreignId('pic_document_id')->constrained('pic_documents')->onDelete('cascade');
            $table->string('payment_code');
            $table->string('payment_type');
            $table->double('amount');
            $table->date('payment_date');
            $table->string('payment_method');
            $table->longText('payment_file');
            $table->text('note')->nullable();
            $table->boolean('is_valid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notary_paymentts');
    }
};
