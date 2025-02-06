<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details_factures', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('facture_id')->unsigned();
            $table->bigInteger('produit_id')->unsigned();
            $table->float('tva')->nullable();
            $table->foreign('facture_id')->references('id')->on('factures')->onDelete('cascade');
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
        Schema::dropIfExists('details_factures');
    }
}
