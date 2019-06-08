<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'title' => 'Title goes here',
            'content' => 'Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. Body goes here, some lorem ipsum. ',
            'user_id' => '1',
            'created_at' => '2019-05-03 11:01:00',
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
