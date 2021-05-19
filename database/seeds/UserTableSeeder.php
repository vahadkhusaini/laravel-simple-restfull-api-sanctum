<?php

use Illuminate\Database\Seeder;
use App\User;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('secret'),
            'role' => 'admin'
        ]);
        
        User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('secret'),
            'role' => 'users'
        ]);
    }
}
