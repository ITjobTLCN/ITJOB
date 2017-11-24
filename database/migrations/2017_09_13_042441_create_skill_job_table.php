<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillJobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('skill_job',function(Blueprint $table){
            $table->integer('job_id')->unsigned();
            $table->integer('skill_id')->unsigned();
            $table->primary(['job_id','skill_id']);
            $table->index(['job_id','skill_id']);
            $table->foreign('job_id')->references('id')->on('jobs');
            $table->foreign('skill_id')->references('id')->on('skills');
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
        Schema::dropIfExists('skill_job');
    }
}
