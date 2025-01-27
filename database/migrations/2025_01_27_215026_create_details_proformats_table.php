<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsProformatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details_proformats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('proformat_id')->unsigned();
            $table->bigInteger('produit_id')->unsigned();
            $table->integer('quantite')->nullable(false);
            $table->decimal('prix_unitaire', 10, 2)->nullable(false);
            $table->decimal('sous_total', 10, 2)->nullable(false);
            $table->float('tva')->nullable();
            $table->foreign('proformat_id')->references('id')->on('proformats')->onDelete('cascade');
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
        Schema::dropIfExists('details_proformats');
    }
}
