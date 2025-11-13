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
        Schema::create('notary_client_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notaris_id')->nullable()->constrained('notaris');
            $table->string('client_code', 50)->nullable();

            $table->foreign('client_code')
                ->references('client_code')
                ->on('clients')
                ->onDelete('set null');

            $table->foreignId('product_id')->nullable()->constrained('products');
            $table->string('progress')->nullable();
            $table->string('progress_date')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('notary_client_progress');
    }
};
