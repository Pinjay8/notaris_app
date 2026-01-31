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
        Schema::table('notary_akta_transactions', function (Blueprint $table) {
            $table->unique('transaction_code', 'notary_akta_transactions_code_unique');
        });
    }

    public function down(): void
    {
        Schema::table('notary_akta_transactions', function (Blueprint $table) {
            $table->dropUnique('notary_akta_transactions_code_unique');
        });
    }
};
