<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('seen')->nullable();
            $table->string('from')->nullable();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('file_service_id')->unsigned()->index()->nullable();
            $table->integer('ticket_id')->unsigned()->index()->nullable();
            $table->integer('comment_id')->unsigned()->index()->nullable();
            $table->string('subject');
            $table->string('email_type');
            $table->string('sent')->nullable();
            $table->decimal('amount')->nullable();
            $table->integer('company_id')->unsigned()->index();
            $table->text('token')->nullable();
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
        Schema::dropIfExists('mail_histories');
    }
}
