<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->truncate();

        DB::table('users')->insert([
            [   'email' => 'admin@master.com',
                'password' => bcrypt('123123123'),
                'first_name' => 'Admin',
                'address' => 'Phan Thanh, Da Nang' ,
                'token' => '$2a$12$tM8NjSrEcRRg7UKZXGrT4uEs/10Xl57ibpjarPQKzbnfU2ikVCPOi' ,
                'phone' => '0934747602' ,
                'avatar' => 'Master' ,
                'last_name' => 'Master' ,
                'is_admin' => true ,
                'is_master' => true ,
                'is_open' => 1 ,
                'gender' => 1
            ],
        ]);
    }
}
