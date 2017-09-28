<?php

use Illuminate\Database\Seeder;

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
                'created_at'=>new DateTime()
        	],
        	[
        		'name'=>'Nguyễn Bá Đạt',
        		'email'=>'datnguyen.ute@gmail.com',
        		'password'=>bcrypt('123456'),
                'role_id'=>1,
                'created_at'=>new DateTime()
        	],
        ]);
    }
}
