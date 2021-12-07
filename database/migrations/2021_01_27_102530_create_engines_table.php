<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnginesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('engines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('generation_id')->unsigned()->index();
            $table->integer('engine_id');
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('flag')->nullable();
            $table->string('power')->nullable();
            $table->string('torque')->nullable();
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
        Schema::dropIfExists('engines');
    }
}
