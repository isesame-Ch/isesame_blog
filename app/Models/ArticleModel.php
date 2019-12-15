<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class ArticleModel extends BaseModel
{
    use SoftDeletes; // 开启软删除
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function articleCategory()
    {
        return $this->belongsTo(ArticleCategoryModel::class);
    }

    /**
     * 获取文章列表和文章分类
     * @param array $where
     * @param bool $pageSize
     * @param array $columns
     * @param bool $or
     * @param mixed ...$other
     * @return BaseModel[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public static function getList($where = [], $pageSize = false, $columns = ['*'], $or = false, ...$other)
    {
        $query = self::query()
            ->select($columns)
            ->leftJoin('article_category','article.category_id','=','article_category.id')
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
        foreach ($other as $item) {
            if (Arr::has($item, 'limit')) {
                $query = $query->limit($item['limit']);
            }
            if (Arr::has($item, 'offset')) {
                $query = $query->offset($item['offset']);
            }
        }
        return $pageSize ? $query->paginate($pageSize) : $query->get();
    }

}
