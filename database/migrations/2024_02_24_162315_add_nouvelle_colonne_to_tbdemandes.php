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
        Schema::table('demandes', function (Blueprint $table) {
            //
            //
$table->decimal('montant_take', 10, 2)->default(0); // Ajout du champ montant_take
$table->decimal('montant_payer', 10, 2)->default(0); // Ajout du champ montant_payer
$table->decimal('montant_restant', 10, 2)->default(0); // Ajout du champ montant_restant

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demandes', function (Blueprint $table) {
            //
        });
    }
};
