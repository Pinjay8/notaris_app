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
        Schema::create('notary_letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notaris_id')->constrained('notaris');
            // $table->foreignId('client_id')->constrained('clients');
            $table->string('client_code', 50)->nullable();

            $table->foreign('client_code')
                ->references('client_code')
                ->on('clients')
                ->onDelete('set null');
            $table->string('letter_number')->nullable();
            $table->string('type')->nullable();
            $table->string('recipient')->nullable();
            $table->string('subject')->nullable();
            $table->date('date')->nullable();
            $table->text('summary')->nullable();
            $table->string('attachment')->nullable();
            $table->longText('file_path')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notary_letters');
    }
};
