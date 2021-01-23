<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('user_id')->default(0);
            $table->boolean('total_score')->default(0);
            $table->boolean('words_score')->default(0);
            $table->boolean('sentences_score')->default(0);
            $table->boolean('nouns_score')->default(0);
            $table->boolean('verbs_score')->default(0);
            $table->boolean('adjectives_score')->default(0);
            $table->boolean('pronouns_score')->default(0);
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
        Schema::dropIfExists('scores');
    }
}
