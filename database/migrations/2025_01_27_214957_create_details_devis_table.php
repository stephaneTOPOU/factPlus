<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsDevisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details_devis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('devis_id')->unsigned();
            $table->bigInteger('produit_id')->unsigned();
            $table->integer('quantite')->nullable();
            $table->decimal('prix_unitaire', 10, 2)->nullable();
            $table->decimal('sous_total', 10, 2)->nullable();
            $table->float('tva')->nullable();
            $table->foreign('devis_id')->references('id')->on('devis')->onDelete('cascade');
            $table->foreign('produit_id')->references('id')->on('produits')->onDelete('cascade');
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
        Schema::dropIfExists('details_devis');
    }
}
