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
        Schema::create('notary_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notaris_id')->constrained('notaris')->onDelete('cascade');
            $table->string('client_code', 50)->nullable();

            $table->foreign('client_code')
                ->references('client_code')
                ->on('clients')
                ->onDelete('set null');

            $table->foreignId('pic_document_id')->constrained('pic_documents')->onDelete('cascade');
            $table->string('payment_code');
            $table->double('product_cost');
            $table->double('admin_cost')->nullable();
            $table->double('other_cost')->nullable();
            $table->double('total_cost');
            $table->double('amount_paid')->nullable();
            $table->string('payment_status');
            $table->date('paid_date')->nullable();
            $table->date('due_date');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notary_costs');
    }
};
