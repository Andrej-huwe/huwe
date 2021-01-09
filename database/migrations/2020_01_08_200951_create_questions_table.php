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
            $table->float('score')->default(0);
            $table->float('actualScore');
            $table->boolean('awardOne')->default(0);
            $table->boolean('awardTwo')->default(0);
            $table->boolean('awardThree')->default(0);
            $table->boolean('awardFour')->default(0);
            $table->boolean('awardFive')->default(0);
            $table->boolean('awardSix')->default(0);
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
