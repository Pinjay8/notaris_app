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
        Schema::create('notary_akta_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notaris_id')->constrained('notaris');
            $table->enum('category', ['pendirian', 'perubahan', 'pemutusan'])->nullable();
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->text('documents')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notary_akta_types');
    }
};
