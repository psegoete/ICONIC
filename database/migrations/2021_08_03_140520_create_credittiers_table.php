<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCredittiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credittiers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('from')->default(0);
            $table->decimal('for')->default(0);
            $table->bigInteger('credit_group_id')->unsigned()->index();
            $table->bigInteger('credittier_amounts_id')->unsigned()->index();
            $table->integer('company_id')->unsigned()->index();
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('credit_group_id')->references('id')->on('credit_groups')->onDelete('cascade');
            $table->foreign('credittier_amounts_id')->references('id')->on('credittier_amounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credittiers');
    }
}
