<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('awards', function (Blueprint $table) {
            $table->bigIncrements('id');
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
        Schema::dropIfExists('awards');
    }
}
