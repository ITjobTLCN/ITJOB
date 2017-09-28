<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('jobs',function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('alias');
            $table->string('detail');
            $table->string('job_description');
            $table->string('require');
            $table->string('treatment');
            $table->integer('status')->default(1);
            $table->integer('user_id')->unsigned();
            $table->integer('employer_id')->unsigned();
            $table->integer('city_id')->unsigned();
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
        //
        Schema::dropIfExists('jobs');
    }
}
