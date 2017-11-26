<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TableCitySeeder::class);
        // $this->call(TableEmployerSeeder::class);
        $this->call(TableJobsSeeder::class);
        // $this->call(TableRoleSeeder::class);
        // $this->call(TableSkillSeeder::class);
        // $this->call(TableUsersSeeder::class);
    }
}
