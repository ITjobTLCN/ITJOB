<?php

use Illuminate\Database\Seeder;
class TableCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
        	[
        		'name'=>'Hồ Chí Minh',
        		'alias'=>'Ho-Chi-Minh',
        		'created_at'=>new DateTime()
        	],
        	[
        		'name'=>'Hà Nội',
        		'alias'=>'Ha-Noi',
        		'created_at'=>new DateTime()
        	],
        	[
        		'name'=>'Đà Nẵng',
        		'alias'=>'Da-Nang',
        		'created_at'=>new DateTime()
        	],
        ]);
    }
}
