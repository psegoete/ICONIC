<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTuningOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tuning_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('label');
            $table->string('tooltip')->nullable();
            $table->decimal('credits');
            $table->bigInteger('tuning_type_id')->unsigned()->index();
            $table->integer('company_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('tuning_type_id')->references('id')->on('tuning_types')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tuning_options');
    }
}
