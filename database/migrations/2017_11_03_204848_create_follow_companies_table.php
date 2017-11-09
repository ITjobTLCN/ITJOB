<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow_companies', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('comp_id')->unsigned();
            $table->primary(['user_id', 'comp_id']);
            $table->index(['user_id','comp_id']);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('comp_id')->references('id')->on('employers');
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
        Schema::dropIfExists('follow_companies');
    }
}
