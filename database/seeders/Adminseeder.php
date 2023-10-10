<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
            [
                'email' => 'admin@master.com',
                'password' => bcrypt('123123123'),
                'first_name' => 'Admin',
                'address' => 'Phan Thanh, Da Nang' ,
                'phone' => '0934747602' ,
                'avatar' => 'Master' ,
                'last_name' => 'Master' ,
                'is_admin' => true ,
                'is_master' => true ,
                'is_open' => 1 ,
                'gender' => 1
            ],
        ]);

        DB::table('customers')->insert([
            [
                'email' => 'dangngockhai@gmail.com',
                'password' => bcrypt('123123123'),
                'name' => 'Dang Ngoc Khai',
                'phone' => '0934747602',
                'address' => 'Phan Thanh, Da Nang',
                'description' => Str::random(30),
                'amount' => 100000000,
                'is_active' => true,
            ],
        ]);
    }
}
