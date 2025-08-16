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
        Schema::create('notary_client_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notaris_id')->nullable()->constrained('notaris');
            $table->foreignId('client_id')->nullable()->constrained('clients');
            $table->string('registration_code')->nullable();
            $table->foreignId('product_id')->nullable()->constrained('products');
            $table->text('note')->nullable();
            $table->string('status');
            $table->string('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notary_client_products');
    }
};
