<?php

use Illuminate\Database\Seeder;
use MongoDB\BSON\UTCDateTime;
class TableJobsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::collection('jobss')->insert([
        	[
        		"name"=>"Công việc 1",
	        	"alias"=>"cv-1",
	        	"user_id"=>4,
	        	"city_id"=>1,
                'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000)),
        	],
        	[
        		"name"=>"Công việc 2",
	        	"alias"=>"cv-2",
	        	"user_id"=>4,
	        	"city_id"=>2,
                'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000)),
        	],
            [
                "name"=>"Công việc 3",
                "alias"=>"cv-3",
                "user_id"=>4,
                "city_id"=>1,
                'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000)),
            ]
        ]);
    }
}
