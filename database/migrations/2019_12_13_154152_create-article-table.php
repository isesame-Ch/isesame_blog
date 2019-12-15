<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('category_id')->unsigned()->comment('所属分类ID');
            $table->string('article_name',50)->default('')->comment('文章名称');
            $table->string('article_author',50)->default('隐士')->comment('文章作者');
            $table->string('article_describe',50)->default('')->comment('文章摘要');
            $table->string('keywords_one',20)->default('')->comment('文章关键字1');
            $table->string('keywords_two',20)->default('')->comment('文章关键字2');
            $table->string('keywords_three',20)->default('')->comment('文章关键字3');
            $table->text('article_content')->comment('文章内容');
            $table->string('article_img',120)->default('/article_img/article_default_img.png')->comment('文章首图');
            $table->integer('article_view')->unsigned()->default(0)->comment('查看人数');
            $table->tinyInteger('article_type')->default(1)->comment('文章的模式:1为公开，2为私有');
            $table->tinyInteger('article_support')->default(1)->comment('是否博主推荐:1为否，2为是');
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
        Schema::dropIfExists('article');
    }
}
