<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
            'name' => 'User',
            'username' => 'user1',
            'email' => 'user@gmail.com',
            'password' => bcrypt('userpswrd'),
            'profile_pic' => 'user.png',
            'created_at' => '2019-05-03 11:01:00',
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
