<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowEmployersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow_employers', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('emp_id')->unsigned();
            $table->primary(['user_id', 'emp_id']);
            $table->index(['user_id','emp_id']);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('emp_id')->references('id')->on('employers');
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
        Schema::dropIfExists('follow_employers');
    }
}
