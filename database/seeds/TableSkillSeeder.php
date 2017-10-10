<?php

use Illuminate\Database\Seeder;

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
        		'created_at'=>new DateTime()
        	],
        	[
        		'name'=>'Java',
        		'alias'=>'java',
        		'created_at'=>new DateTime()
        	],
        	[
        		'name'=>'PHP',
        		'alias'=>'php',
        		'created_at'=>new DateTime()
        	],
        	[
        		'name'=>'iOS',
        		'alias'=>'ios',
        		'created_at'=>new DateTime()
        	],
        	[
        		'name'=>'.NET',
        		'alias'=>'.net',
        		'created_at'=>new DateTime()
        	],
        	[
        		'name'=>'Tester',
        		'alias'=>'tester',
        		'created_at'=>new DateTime()
        	],
        	[
        		'name'=>'Wordpress',
        		'alias'=>'wordpress',
        		'created_at'=>new DateTime()
        	]
        ]);
    }
}
