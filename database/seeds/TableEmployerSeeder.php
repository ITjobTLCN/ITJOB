<?php

use Illuminate\Database\Seeder;
use MongoDB\BSON\UTCDateTime;
class TableEmployerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employers')->insert([
        	[
        		'name'=>'Global CyberSoft',
        		'alias'=>'global-cyber-soft',
        		'address'=>'Helios Bldg, Phần mềm Quang Trung, Phường Tân Chánh Hiệp, Quận 12, Thành phố Hồ Chí Minh',
                'city_id'=>'1',
                'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000)),
        	],
        	[
        		'name'=>'FPT Software',
        		'alias'=>'fpt-software',
        		'address'=>'Lô T2, đường D1, khu công nghệ cao, Phường Tân Phú, Quận 9, Thành phố Hồ Chí Minh',
                'city_id'=>'1',
                'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000)),
        	],
        	[
        		'name'=>'Episerver',
        		'alias'=>'episerver',
        		'address'=>'Flemington, 182 Lê Đại Hành, Phường 15, Quận 11, Thành phố Hồ Chí Minh',
                'city_id'=>'1',
                'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000)),
        	],
            [
                'name'=>'IFI Solution - An NTT Data Company',
                'alias'=>'ifi-solution-an-ntt-data-company',
                'address'=>'Thanh Xuân, Hà Nội',
                'city_id'=>'2',
                'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000)),
            ]
        ]);
    }
}
