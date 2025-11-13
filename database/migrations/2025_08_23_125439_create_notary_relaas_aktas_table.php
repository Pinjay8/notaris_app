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
        Schema::create('notary_relaas_aktas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notaris_id')->constrained('notaris');
            $table->string('client_code', 50)->nullable();

            $table->foreign('client_code')
                ->references('client_code')
                ->on('clients')
                ->onDelete('set null');

            $table->year('year')->nullable();
            $table->foreignId('relaas_type_id')->constrained('relaas_types');
            $table->string('relaas_number')->nullable();
            $table->dateTime('relaas_number_created_at')->nullable();
            $table->string('title')->nullable();
            $table->text('story')->nullable();
            $table->dateTime('story_date')->nullable();
            $table->string('story_location')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('notary_relaas_aktas');
    }
};
