<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleModel extends BaseModel
{
    protected $table = 'article';

    /**
     * 不可以被批量赋值的属性。
     * @var array
     */
    protected $guarded = [''];

    /**
     * 可以被批量赋值的属性。
     * @var array
     */
    #protected $fillable = [''];

}
