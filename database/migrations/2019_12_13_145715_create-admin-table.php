<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integerIncrements('id');
            $table->integer('user_id')->unsigned()->comment('用户主表ID');
            $table->tinyInteger('identity')->default(1)->comment('管理员权限,1:管理员，2：超级管理员');
            $table->tinyInteger('status')->default(1)->comment('状态，1：正常，2：禁用');
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
        Schema::dropIfExists('admin');
    }
}
