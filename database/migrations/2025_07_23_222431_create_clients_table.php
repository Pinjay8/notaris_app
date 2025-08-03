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
            $table->foreignId('notaris_id')->constrained('notaris')->onDelete('cascade');
            $table->string('fullname');
            $table->string('nik');
            $table->string('birth_place');
            $table->string('gender');
            $table->string('marital_status');
            $table->string('job');
            $table->string('address');
            $table->string('city');
            $table->string('province');
            $table->string('postcode');
            $table->string('phone');
            $table->string('email');
            $table->string('npwp');
            $table->enum('type', ['personal', 'company']);
            $table->string('company_name');
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
