<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('entreprise')->nullable();
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('telephone')->unique()->nullable();
            $table->string('adresse')->nullable();
            $table->enum('type_client',['Entreprise','Particulier'])->default('Entreprise');
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
        Schema::dropIfExists('clients');
    }
}
