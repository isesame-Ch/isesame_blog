<?php
/**
 * Created by PhpStorm.
 * User: 79834
 * Date: 2019/12/14
 * Time: 3:24
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    public static function getList($where = [], $pageSize = false, $columns = ['*'], $or = false)
    {
        $query = self::query()
            ->select($columns)
            ->where(function ($model) use ($where, $or) {
                foreach ($where as $field => $value) {
                    if ($value instanceof \Closure) {
                        $model = (!$or)
                            ? $model->where($value)
                            : $model->orWhere($value);
                    } elseif (is_array($value)) {
                        if (count($value) === 3) {
                            list($field, $operator, $search) = $value;
                            $model = (!$or)
                                ? $model->where($field, $operator, $search)
                                : $model->orWhere($field, $operator, $search);
                        } elseif (count($value) === 2) {
                            list($field, $search) = $value;
                            $model = (!$or)
                                ? $model->where($field, '=', $search)
                                : $model->orWhere($field, '=', $search);
                        }
                    } else {
                        $model = (!$or)
                            ? $model->where($field, '=', $value)
                            : $model->orWhere($field, '=', $value);
                    }

                }
            });

        return $pageSize ? $query->paginate($pageSize) : $query->get();
    }
}