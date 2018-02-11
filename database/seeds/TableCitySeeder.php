<?php

use Illuminate\Database\Seeder;
use MongoDB\BSON\UTCDateTime;
class TableCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::collection('cities')->insert([
        	[
        		'name' => 'Hồ Chí Minh',
        		'alias' => 'ho-chi-minh',
        		'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000)),
        	],
        	[
        		'name' => 'Hà Nội',
        		'alias' => 'ha-noi',
        		'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000)),
        	],
        	[
        		'name' => 'Đà Nẵng',
        		'alias' => 'da-nang',
        		'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000)),
        	],
        ]);
    }
}
