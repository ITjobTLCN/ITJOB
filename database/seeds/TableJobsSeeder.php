<?php

use Illuminate\Database\Seeder;

class TableJobsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jobs')->insert([
        	[
        		"name"=>"công việc 1",
	        	"alias"=>"cv-1",
	        	"user_id"=>3,
	        	"emp_id"=>1,
	        	"city_id"=>1,
                'created_at'=>new DateTime()
        	],
        	[
        		"name"=>"công việc 2",
	        	"alias"=>"cv-2",
	        	"user_id"=>1,
	        	"emp_id"=>1,
	        	"city_id"=>2,
                'created_at'=>new DateTime()
        	]
        ]);
    }
}
