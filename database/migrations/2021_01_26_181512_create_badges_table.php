<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('userId')->nullable();
            $table->string('name')->nullable();
            $table->string('desc')->default('opis ocenenia');
            $table->float('unlock_at')->default(0);
            $table->float('show_at')->default(0);
            $table->string('img')->nullable();;
            $table->boolean('status')->default(0); // zmena z čiernobielej na farebnú
            $table->boolean('new_award')->default(0); // pri získaní nového ocenenia
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
        Schema::dropIfExists('badges');
    }
}
