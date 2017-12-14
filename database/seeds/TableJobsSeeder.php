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
        		"name"=>"Công việc 1",
	        	"alias"=>"cv-1",
	        	"user_id"=>4,
	        	"emp_id"=>1,
	        	"city_id"=>1,
                'created_at'=>new DateTime()
        	],
        	[
        		"name"=>"Công việc 2",
	        	"alias"=>"cv-2",
	        	"user_id"=>4,
	        	"emp_id"=>1,
	        	"city_id"=>2,
                'created_at'=>new DateTime()
        	],
            [
                "name"=>"Công việc 3",
                "alias"=>"cv-3",
                "user_id"=>4,
                "emp_id"=>2,
                "city_id"=>1,
                'created_at'=>new DateTime()
            ]
        ]);
    }
}
