<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_auth', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->comment('自增ID');
            $table->integer('user_id')->comment('用户ID');
            $table->tinyInteger('identity_type')->comment('登录类型,1:账号,2:QQ');
            $table->string('identifier')->comment('账号或第三方唯一标识');
            $table->string('credential')->comment('密码凭证，密码或第三方token');
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
        Schema::dropIfExists('user_auth');
    }
}
