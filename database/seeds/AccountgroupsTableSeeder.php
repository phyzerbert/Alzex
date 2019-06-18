<?php

use Illuminate\Database\Seeder;
use App\Models\Accountgroup;

class AccountgroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Accountgroup::create(['name' => 'Cash Account']);
        Accountgroup::create(['name' => 'Credit Account']);
        Accountgroup::create(['name' => 'Bank Account']);
    }
}
