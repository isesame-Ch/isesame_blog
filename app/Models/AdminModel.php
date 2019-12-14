<?php

namespace App\Models;

class AdminModel extends BaseModel
{
    protected $table = 'admin';

    /**
     * 不可以被批量赋值的属性。
     * @var array
     */
    #protected $guarded = [''];

    /**
     * 可以被批量赋值的属性。
     * @var array
     */
    #protected $fillable = [''];
}
