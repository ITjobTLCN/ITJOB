<?php

use Illuminate\Database\Seeder;
use MongoDB\BSON\UTCDateTime;
class TableRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
        	[
	        	'name' => 'candidate',
	        	'detail' => 'Ứng viên',
                'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000))
        	],
            [
                'name'=>'admin',
                'detail'=>'Người quản trị',
                'created_at'=> new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000))
            ],
        	[
	        	'name' => 'employer',
	        	'detail' => 'Công ty',
                'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000))
        	],
            [
                'name' => 'employee',
                'detail' => 'Nhân viên',
                'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000))
            ],
        ]);
    }
}
