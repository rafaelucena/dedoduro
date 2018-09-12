<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'is_active' => true,
        ]);

        $registerController = new RegisterController();
        $registerController->attachRoles($adminUser);
    }
}
