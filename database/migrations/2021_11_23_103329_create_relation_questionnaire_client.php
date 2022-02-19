<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationQuestionnaireClient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_questionnaire_client', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('questionnaire_id');
            $table->foreign('questionnaire_id')->references('id_questionnaire')->on('questionnaires');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id_client')->on('clients');
            $table->string('repondu')->nullable();
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
        Schema::dropIfExists('relation_questionnaire_client');
    }
}
