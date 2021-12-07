<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name')->unique();
            $table->string('address1');
            $table->string('address2');
            $table->string('zipcode')->nullable();
            $table->string('city')->nullable();
            $table->string('timezone')->nullable();
            $table->string('domain_name')->unique();
            $table->uuid('uuid')->nullable();
            $table->integer('active')->nullable()->default(0);
            $table->string('province')->nullable();
            $table->integer('blocked')->nullable()->default(0);;
            $table->string('country')->nullable();
            $table->string('company_email')->index();
            $table->string('company_phone')->nullable();
            $table->string('company_logo')->default('/uploads/images/avatar.png');
            $table->string('phone_number')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_identification_code')->nullable();
            $table->string('chamber_of_commernce_number')->nullable();
            $table->string('tax_identifier')->nullable();
            $table->string('skype_username')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('google')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            $table->string('instagram')->nullable();
            $table->string('pinterest')->nullable();
            $table->string('wechat')->nullable();
            $table->string('qq')->nullable();
            $table->string('website')->nullable();
            $table->string('plan');
            $table->string('google_tag_manager_code')->nullable();
            $table->string('google_analytics_code')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
