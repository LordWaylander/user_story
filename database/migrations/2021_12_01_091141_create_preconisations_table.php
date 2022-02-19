<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreconisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preconisations', function (Blueprint $table) {
            $table->id('id_preconisation');
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id_question')->on('questions');
            $table->integer('note_reponse');
            $table->string('conseil');
            $table->string('type_reponse');
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
        Schema::dropIfExists('preconisations');
    }
}
