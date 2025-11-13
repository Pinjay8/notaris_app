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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_code')->nullable()->unique();
            $table->uuid('uuid')->nullable();
            $table->foreignId('notaris_id')->constrained('notaris')->onDelete('cascade');
            $table->string('fullname');
            $table->string('nik');
            $table->string('birth_place');
            $table->string('gender');
            $table->string('marital_status');
            $table->string('job');
            $table->string('address')->nullable();
            $table->string('city');
            $table->string('province');
            $table->string('postcode')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('npwp')->nullable();
            $table->enum('type', ['personal', 'company'])->nullable();
            $table->string('company_name')->nullable();
            $table->string('status');
            $table->string('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
