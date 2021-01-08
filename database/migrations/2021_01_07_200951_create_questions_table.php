<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->increments('score')->default(0);
            $table->increments('actualScore');
            $table->increments('awardOne')->default(0);
            $table->increments('awardTwo')->default(0);
            $table->increments('awardThree')->default(0);
            $table->increments('awardFour')->default(0);
            $table->increments('awardFive')->default(0);
            $table->increments('awardSix')->default(0);
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
        Schema::dropIfExists('questions');
    }
}
