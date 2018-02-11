<?php

use Illuminate\Database\Seeder;
use MongoDB\BSON\UTCDateTime;
class TableSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('skills')->insert([
        	[
        		'name'=>'Android',
        		'alias'=>'android',
        		'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000)),
        	],
        	[
        		'name'=>'Java',
        		'alias'=>'java',
        		'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000)),
        	],
        	[
        		'name'=>'PHP',
        		'alias'=>'php',
        		'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000)),
        	],
        	[
        		'name'=>'iOS',
        		'alias'=>'ios',
        		'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000)),
        	],
        	[
        		'name'=>'.NET',
        		'alias'=>'.net',
        		'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000)),
        	],
        	[
        		'name'=>'Tester',
        		'alias'=>'tester',
        		'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000)),
        	],
        	[
        		'name'=>'Wordpress',
        		'alias'=>'wordpress',
        		'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000)),
        	]
        ]);
    }
}
