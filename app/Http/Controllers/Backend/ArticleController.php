<?php
/**
 * Created by PhpStorm.
 * User: 79834
 * Date: 2018/8/1
 * Time: 16:22
 */

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Http\Services\ArticleCategoryService;
use App\Http\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    
    public $articleService;

    public function __construct(ArticleService $articleService) {
//        $this->middleware('auth', [
//            'only' => ['show', 'create', 'store']
//        ]);

        $this->articleService = $articleService;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getList(Request $request)
    {
        $rules = [
            'category_id' => 'integer|nullable',
            'article_name' => 'string|nullable',
            'article_author' => 'string|nullable|max:20',
        ];

        $this->setKeyContent($this->articleService->getList(
            $this->filterParams($request,$rules),
            $request->input('page_size',10)
        ));
        return $this->responseArray();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function detail(Request $request)
    {
        $rules = [
            'article_id' => 'required|integer'
        ];

        $this->setKeyContent($this->articleService->detail(
            $this->filterParams($request,$rules)
        ));
        return $this->responseArray();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getSupportList(Request $request)
    {
        $rules = [
            'category_id' => 'integer|nullable',
            'article_name' => 'string|nullable',
            'article_author' => 'string|nullable|max:20',
            'article_support' => 'in:2'
        ];

        $this->setKeyContent($this->articleService->getList(
            $this->filterParams($request,$rules),
            $request->input('page_size',10)
        ));
        return $this->responseArray();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store($id)
    {
        return view('APP.article',['id' => $id]);
    }
}