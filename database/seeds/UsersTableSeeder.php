<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin1',
            'password' => bcrypt('123456'),
            'phone_number' => '+573146248006',
            'role_id' => 1,
        ]);
    }
}
