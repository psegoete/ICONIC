<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLegalDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legal_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->text('privancy_policy')->nullable();
            $table->text('refund_policy')->nullable();
            $table->text('terms_and_conditions')->nullable();
            $table->text('disclaimer')->nullable();
            $table->integer('company_id')->unsigned()->index();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**ss
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('legal_documents');
    }
}
