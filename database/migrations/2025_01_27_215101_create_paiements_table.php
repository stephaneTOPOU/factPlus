<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaiementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('facture_id')->unsigned();
            $table->decimal('montant', 10, 2)->nullable(false); // DECIMAL(10, 2) NOT NULL
            $table->date('date_paiement')->nullable(false); // DATE NOT NULL
            $table->string('moyen_paiement')->nullable();
            $table->foreign('facture_id')->references('id')->on('factures')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paiements');
    }
}
