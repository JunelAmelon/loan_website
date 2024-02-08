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
       Schema::create('remboursements', function (Blueprint $table) {
    $table->id();
    $table->foreignId('client_id')->constrained('clients');
    $table->decimal('montant_take', 10, 2);
    $table->decimal('montant_payer', 10, 2);
    $table->decimal('montant_restant', 10, 2);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remboursements');
    }
};
