<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->schid('schid');
            $table->string('name')->nullable();
            $table->string('desc')->nullable();
            $table->string('difficulty')->nullable();
            $table->string('type')->nullable();
            $table->boolean('unlock_at')->default(0);
            $table->boolean('disable')->default(false);
            $table->boolean('completed_steps')->default(0);
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
        Schema::dropIfExists('lessons');
    }
}
