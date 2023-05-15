<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'full_name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password')
        ]);
        $user->assignRole('administrator');
        
        $user2 = User::create([
            'full_name' => 'Artist',
             'email' => 'user@user.com',
            'password' => bcrypt('password')
        ]);
        $user2->assignRole('user');
       
    }
}
