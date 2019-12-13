<?php
/**
 * Created by PhpStorm.
 * User: 79834
 * Date: 2018/8/1
 * Time: 16:22
 */

namespace App\Http\Controllers\APP;


use App\Http\Controllers\Controller;
use App\Http\Services\ArticleCategoryService;
use App\Http\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    
    public $articleService;

    public function __construct() {
        
    }

    public function getList(Request $request)
    {
        $rules = [
            'category_id' => 'integer|nullable',
            'article_name' => 'string|nullable',
            'article_author' => 'string|nullable|max:20',
        ];

        $this->setKeyContent(app(ArticleService::class)->getList(
            $this->filterParams($request,$rules),
            $request->input('page_size',10)
        ));
        return $this->responseArray();
    }

    public function detail(Request $request)
    {
        $rules = [
            'article_id' => 'required|integer'
        ];

        $this->setKeyContent(app(ArticleService::class)->detail(
            $this->filterParams($request,$rules)
        ));
        return $this->responseArray();
    }

    public function getSupportList(Request $request)
    {
        $rules = [
            'category_id' => 'integer|nullable',
            'article_name' => 'string|nullable',
            'article_author' => 'string|nullable|max:20',
            'article_support' => 'in:2'
        ];

        $this->setKeyContent(app(ArticleService::class)->getList(
            $this->filterParams($request,$rules),
            $request->input('page_size',10)
        ));
        return $this->responseArray();
    }
}