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
        Schema::create('pic_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notaris_id')->constrained('notaris')->onDelete('cascade');
            $table->string('pic_document_code')->nullable();
            $table->foreignId('pic_id')->constrained('pic_staff')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('clients');
            $table->string('registration_code')->nullable();
            $table->string('document_type')->nullable();
            $table->string('document_number')->nullable();
            $table->dateTime('received_date')->nullable();
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
        Schema::dropIfExists('pic_documents');
    }
};
