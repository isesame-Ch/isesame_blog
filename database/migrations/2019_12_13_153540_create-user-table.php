<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username',255)->comment('用户账号');
            $table->string('password',255)->comment('用户密码');
            $table->string('nickname',255)->comment('用户昵称');
            $table->string('email',255)->default('')->comment('邮箱');
            $table->string('head_pic',255)->default('/user_head/default_user_head.png')->comment('邮箱');
            $table->tinyInteger('status')->default(1)->comment('状态，1：正常，2：禁用');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
