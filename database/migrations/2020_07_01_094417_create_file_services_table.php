<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('generation')->nullable();
            $table->string('engine')->nullable();
            $table->string('ecu')->nullable();
            $table->string('engine_hp')->nullable();
            $table->string('engine_kw')->nullable();
            $table->string('year');
            $table->string('gearbox');
            $table->string('license_plate')->nullable();
            $table->string('vin');
            $table->string('fuel_octane_rating')->nullable();
            $table->string('read_method');
            $table->string('tuning_type');
            $table->string('tuning_options')->nullable();
            $table->string('file_to_modify')->nullable();
            $table->string('file_to_modify_title')->nullable();
            $table->string('notes')->nullable();
            $table->string('status')->nullable();
            $table->string('modified')->nullable();
            $table->string('modified_title')->nullable();
            $table->string('dynograph')->nullable();
            $table->string('dynograph_title')->nullable();
            $table->string('timeframe');
            $table->string('dyno');
            $table->string('info')->nullable();
            $table->string('downloaded_file_service')->nullable();
            $table->decimal('credits')->nullable();
            $table->integer('company_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_services');
    }
}
