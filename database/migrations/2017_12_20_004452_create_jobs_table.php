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
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('alias');
            $table->string('salary')->nullable();
            $table->text('description')->nullable();
            $table->text('require')->nullable();
            $table->text('treatment')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('emp_id')->unsigned();
            $table->integer('city_id')->unsigned();
            $table->integer('status')->default(1);
            $table->integer('follow')->default(0);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('emp_id')->references('id')->on('employers');
            $table->foreign('city_id')->references('id')->on('cities');

            $table->index('name');
            $table->index('alias');
            $table->index('city_id');
            $table->index('follows');
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
        Schema::dropIfExists('jobs');
    }
}
