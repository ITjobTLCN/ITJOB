<?php

use Illuminate\Database\Seeder;
use MongoDB\BSON\UTCDateTime;
class TableUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	[
        		'name'=>'Trần Thanh Phong',
        		'email'=>'phong.kelvin1608@gmail.com',
        		'password'=>bcrypt('123456'),
                'role_id'=>1,
                'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000)),
        	],
        	[
        		'name'=>'Nguyễn Bá Đạt',
        		'email'=>'datnguyen.ute@gmail.com',
        		'password'=>bcrypt('123456'),
                'role_id'=>2,
                'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000)),
        	],
            [
                'name'=>'kelvin',
                'email'=>'tranthanhphong1608@gmail.com',
                'password'=>bcrypt('123456'),
                'role_id'=>3,
                'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000)),
            ],
            [
                'name'=>'phong',
                'email'=>'company@gmail.com',
                'password'=>bcrypt('123456'),
                'role_id'=>4,
                'created_at' => new UTCDateTime(round(microtime(true) * 1000)),
                'updated_at' => new UTCDateTime(round(microtime(true) * 1000)),
            ],
        ]);
    }
}
