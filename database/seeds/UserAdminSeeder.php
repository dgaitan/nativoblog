<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Taylor',
            'last_name' => 'Otwell',
            'email' => 'taylor@otwell.com',
            'password' => Hash::make('secret')
        ])->makeAdmin();
    }
}
