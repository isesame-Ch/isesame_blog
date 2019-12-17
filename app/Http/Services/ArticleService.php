<?php

namespace App\Http\Services;


use App\Http\Services\BaseService;
use App\Models\ArticleCategoryModel;

class ArticleService extends BaseService
{
    /**
     * 文章分类列表
     * @param bool $pageSize
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getArticleCategoryList($pageSize = false)
    {
        if ($pageSize) {
            return ArticleCategoryModel::query()->paginate($pageSize);
        }
        return ArticleCategoryModel::query()->get();
    }
}
