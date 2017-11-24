<?php

use Illuminate\Database\Seeder;

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
        		'address'=>'Helios Bldg, Phần mềm Quang Trung, Phường Tân Chánh Hiệp, Quận 12, Hồ Chí Minh'
        	],
        	[
        		'name'=>'FPT Software',
        		'alias'=>'fpt-software',
        		'address'=>'Helios Bldg, Phần mềm Quang Trung, Phường Tân Chánh Hiệp, Quận 12, Hồ Chí Minh'
        	],
        	[
        		'name'=>'VNG Corporation',
        		'alias'=>'vng-corporation',
        		'address'=>'Helios Bldg, Phần mềm Quang Trung, Phường Tân Chánh Hiệp, Quận 12, Hồ Chí Minh'
        	]

        ]);
    }
}
