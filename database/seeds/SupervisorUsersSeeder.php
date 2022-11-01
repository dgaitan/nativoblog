<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SupervisorUsersSeeder extends Seeder
{
    public static $emails = [
        'adam@watham.com',
        'nuno@maduro.com',
        'matt@deamon.com'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Adam',
            'last_name' => 'Watham',
            'email' => 'adam@watham.com',
            'password' => Hash::make('secret')
        ])->makeSupervisor();

        User::create([
            'name' => 'Nuno',
            'last_name' => 'Maduro',
            'email' => 'nuno@maduro.com',
            'password' => Hash::make('secret'),
        ])->makeSupervisor();

        User::create([
            'name' => 'Matt',
            'last_name' => 'Deamon',
            'email' => 'matt@deamon.com',
            'password' => Hash::make('secret')
        ])->makeSupervisor();
    }
}
