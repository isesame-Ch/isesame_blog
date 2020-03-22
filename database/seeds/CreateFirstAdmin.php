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
            'nickname' => '超级管理员',
            'email' => '123@email.com',
            'created_at' => time()
        ]);
        DB::table('admin')->insert([
            'user_id' => 1,
            'identity' => 3,
            'created_at' => time()
        ]);
        DB::table('user_auth')->insert([
            'user_id' => '1',
            'identity_type' => '1',
            'identifier' => 'admin1234',
            'credential' => md5('admin1234'),
            'created_at' => time()
        ]);
    }
}
