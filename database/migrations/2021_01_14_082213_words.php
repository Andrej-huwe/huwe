<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Words extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('words', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('parent_lesson')->default(0);
            $table->string('question')->nullable();
            $table->string('answer_one')->nullable();
            $table->string('answer_two')->nullable();
            $table->string('answer_four')->nullable();
            $table->string('answer_corrent')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
