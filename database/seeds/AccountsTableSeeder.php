<?php

use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Account::create([
            'name' => 'Cash1',
            'group_id' => 1,
        ]);

        Account::create([
            'name' => 'Cash2',
            'group_id' => 1,
        ]);

        Account::create([
            'name' => 'Visa',
            'group_id' => 2,
        ]);

        Account::create([
            'name' => 'Master',
            'group_id' => 2,
        ]);

        Account::create([
            'name' => 'Bank1',
            'group_id' => 3,
        ]);

        Account::create([
            'name' => 'Bank2',
            'group_id' => 3,
        ]);
    }
}
