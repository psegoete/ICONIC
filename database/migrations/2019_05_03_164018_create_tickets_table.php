<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->string('ticket_id')->unique();
            $table->string('title')->nullable();
            $table->string('priority')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->nullable();
            $table->string('subject')->nullable();
            $table->string('customer_view_status')->nullable();
            $table->string('customer_viewed_status')->nullable();
            $table->string('admin_view_status')->nullable();
            $table->bigInteger('file_service_id')->nullable();
            $table->integer('company_id')->unsigned()->index();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('tickets');
    }
}
