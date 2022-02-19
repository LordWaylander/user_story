<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReponses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reponses', function (Blueprint $table) {
            $table->id('id_reponse');
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id_question')->on('questions');
            $table->string('reponse');
            $table->string('date_reponse');
            $table->unsignedBigInteger('id_user_TEST');
            $table->foreign('id_user_TEST')->references('id')->on('users');
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
        Schema::dropIfExists('reponses');
    }
}
