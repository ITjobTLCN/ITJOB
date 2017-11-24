<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillEmployersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skill_employers', function (Blueprint $table) {
            $table->integer('emp_id')->unsigned();
            $table->integer('skill_id')->unsigned();
            $table->primary(['emp_id','skill_id']);
            $table->index(['emp_id','skill_id']);
            $table->foreign('emp_id')->references('id')->on('employers');
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
        Schema::dropIfExists('skill_employers');
    }
}
