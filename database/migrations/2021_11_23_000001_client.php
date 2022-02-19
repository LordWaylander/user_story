<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Client extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id('id_client');
            $table->string('nom');
            $table->string('mail');
            $table->string('telephone');
            $table->unsignedBigInteger('entreprise_id');
            $table->foreign('entreprise_id')->references('id_entreprise')->on('entreprises');
            $table->integer('status');
            $table->unsignedBigInteger('contact_principal_id');
            $table->foreign('contact_principal_id')->references('id')->on('users');

            $table->string('logo', 2048)->nullable();
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
