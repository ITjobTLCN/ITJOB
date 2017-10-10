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
        		'name'=>'dasdsa',
        		'alias'=>'global-cyber-soft',
        		'address'=>'Helios Bldg, Phần mềm Quang Trung, Phường Tân Chánh Hiệp, Quận 12, Hồ Chí Minh'
        	],
        	[
        		'name'=>'hjuyrr',
        		'alias'=>'global-cyber-soft',
        		'address'=>'Helios Bldg, Phần mềm Quang Trung, Phường Tân Chánh Hiệp, Quận 12, Hồ Chí Minh'
        	]

        ]);
    }
}
