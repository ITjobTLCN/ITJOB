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
        		'alias'=>'ho-chi-minh',
        		'created_at'=>new DateTime()
        	],
        	[
        		'name'=>'Hà Nội',
        		'alias'=>'ha-noi',
        		'created_at'=>new DateTime()
        	],
        	[
        		'name'=>'Đà Nẵng',
        		'alias'=>'da-nang',
        		'created_at'=>new DateTime()
        	],
        ]);
    }
}
