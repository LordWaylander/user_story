<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntreprise extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id('id_entreprise');
            $table->string('nom_entreprise');
            $table->string('adresse_entreprise');
            $table->integer('code_postal');
            $table->string('ville');
            $table->string('denomination_commerciale')->nullable();
            $table->string('forme_juridique')->nullable();
            $table->string('site_exploitation')->nullable();
            $table->string('nb_sites')->nullable();
            $table->integer('siret')->nullable();
            $table->string('rc')->nullable();
            $table->string('activite')->nullable();
            $table->string('code_ape')->nullable();
            $table->string('representant_legal')->nullable();
            $table->string('dpo')->nullable();
            $table->string('directeur_etablissement')->nullable();
            $table->string('telephone')->nullable();
            $table->string('responsable_traitement')->nullable();
            $table->string('sous_traitant')->nullable();
            $table->string('liste_sous_traitant')->nullable();
            $table->string('groupe_user_habilitation_1')->nullable();
            $table->string('groupe_user_habilitation_2')->nullable();
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
        Schema::dropIfExists('entreprise');
    }
}
