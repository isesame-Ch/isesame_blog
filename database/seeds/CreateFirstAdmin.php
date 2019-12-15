<?php

use Illuminate\Database\Seeder;

class CreateFirstAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'username' => 'admin1234',
            'password' => md5('admin1234'),
            'nickname' => '超级管理员',
            'email' => '123@email.com',
            'created_at' => time()
        ]);
        DB::table('admin')->insert([
            'user_id' => 1,
            'identity' => 3,
            'created_at' => time()
        ]);
    }
}
