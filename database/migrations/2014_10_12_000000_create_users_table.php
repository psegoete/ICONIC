<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username')->nullable();
            $table->string('profile_image')->default('images.png');
            $table->string('email');
            $table->string('account_type')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->string('role')->nullable();
            $table->string('business_name')->nullable();
            $table->string('title');
            $table->string('country');
            $table->string('province');
            $table->string('vat_number')->nullable();
            $table->string('ticket_display_name')->nullable();
            $table->string('blocked')->default('0');
            $table->integer('company_id')->unsigned()->index();
            $table->bigInteger('credit_group_id')->unsigned()->index();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unique(['company_id', 'email'], 'composite_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
