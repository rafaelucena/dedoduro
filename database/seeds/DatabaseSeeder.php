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
        $this->call([
            UsersSeeder::class,
            CommandsSeeder::class,
            // SettingsTableSeeder::class,
            // RolesTableSeeder::class,
            // CategoriesTableSeeder::class,
            // BlogsTableSeeder::class,
        ]);
    }
}
