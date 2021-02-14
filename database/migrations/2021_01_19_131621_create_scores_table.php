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
            $table->float('user_id')->default(0);
            $table->float('total_score')->default(0);
            $table->float('words_score')->default(0);
            $table->float('sentences_score')->default(0);
            $table->float('nouns_score')->default(0);
            $table->float('verbs_score')->default(0);
            $table->float('adjectives_score')->default(0);
            $table->float('pronouns_score')->default(0);
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
