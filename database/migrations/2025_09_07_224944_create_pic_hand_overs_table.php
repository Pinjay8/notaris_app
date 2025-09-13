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
        Schema::create('pic_hand_overs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notaris_id')->constrained('notaris')->onDelete('cascade');
            $table->foreignId('pic_document_id')->constrained('pic_documents')->onDelete('cascade');
            $table->date('handover_date');
            $table->string('recipient_name')->nullable();
            $table->string('recipient_contact')->nullable();
            $table->text('note')->nullable();
            $table->longText('file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pic_hand_overs');
    }
};
