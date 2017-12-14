<?php

use Illuminate\Database\Seeder;

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
	        	'name'=>'candidate',
	        	'detail'=>'Ứng viên',
	        	'created_at'=>new DateTime()
        	],
            [
                'name'=>'admin',
                'detail'=>'Người quản trị',
                'created_at'=>new DateTime()
            ],
        	[
	        	'name'=>'employer',
	        	'detail'=>'Công ty',
	        	'created_at'=>new DateTime()
        	],
            [
                'name'=>'employee',
                'detail'=>'Nhân viên',
                'created_at'=>new DateTime()
            ],
        ]);
    }
}
