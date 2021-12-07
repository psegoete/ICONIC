<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('availabilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('monday')->default('Monday');
            $table->time('monday_opening_time')->nullable();
            $table->time('monday_closing_time')->nullable();
            $table->string('monday_status')->nullable();
            $table->string('tuesday')->default('Tuesday');
            $table->time('tuesday_opening_time')->nullable();
            $table->time('tuesday_closing_time')->nullable();
            $table->string('tuesday_status')->nullable();
            $table->string('wednesday')->default('Wednesday');
            $table->time('wednesday_opening_time')->nullable();
            $table->time('wednesday_closing_time')->nullable();
            $table->string('wednesday_status')->nullable();
            $table->string('thursday')->default('Thursday');
            $table->time('thursday_opening_time')->nullable();
            $table->time('thursday_closing_time')->nullable();
            $table->string('thursday_status')->nullable();
            $table->string('friday')->default('Friday');
            $table->time('friday_opening_time')->nullable();
            $table->time('friday_closing_time')->nullable();
            $table->string('friday_status')->nullable();
            $table->string('saturday')->default('Saturday');
            $table->time('saturday_opening_time')->nullable();
            $table->time('saturday_closing_time')->nullable();
            $table->string('saturday_status')->nullable();
            $table->string('sunday')->default('Sunday');
            $table->time('sunday_opening_time')->nullable();
            $table->time('sunday_closing_time')->nullable();
            $table->string('sunday_status')->nullable();
            $table->string('holiday')->default('Holiday');
            $table->time('holiday_opening_time')->nullable();
            $table->time('holiday_closing_time')->nullable();
            $table->string('holiday_status')->nullable();
            $table->timestamps();
            $table->integer('company_id')->unsigned()->index();
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
        Schema::dropIfExists('availabilities');
    }
}
