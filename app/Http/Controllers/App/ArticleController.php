<?php
/**
 * Created by PhpStorm.
 * User: 79834
 * Date: 2018/8/1
 * Time: 16:22
 */

namespace App\Http\Controllers\APP;


use App\Helpers\ErrorCode;
use App\Http\Controllers\Controller;
use App\Http\Services\ArticleCategoryService;
use App\Http\Services\ArticleService;
use App\Models\ArticleModel;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    
    public $articleService;

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    public function __construct(ArticleService $articleService) {
        $this->middleware('user.auth', [
            'only' => ['create', 'store']
        ]);

        $this->articleService = $articleService;
    }

    /**
     * 文章列表
     * @param Request $request
     * @return ArticleController
     * @throws \Exception
     */
    public function getList(Request $request)
    {

        $rules = [
            'category_id' => 'integer|nullable',
            'article_name' => 'string|nullable',
            'article_author' => 'string|nullable|max:20',
        ];

        $articles = $this->obj2Array(
            ArticleModel::getList(
                [],
                $request->input('page_size',10),
                ['article.id','article.article_name','article.article_author','article.article_describe','article.article_img','article.created_at','article.updated_at']
            )
        );

        foreach ($articles['data'] as &$item) {
            $item['created_at'] = date('Y-m-d H:i:s', $item['created_at']);
            $item['updated_at'] = date('Y-m-d H:i:s', $item['updated_at']);
        }

        $this->setKeyContent($articles);
        return $this->responseArray();
    }

    /**
     * @param Request $request
     * @return ArticleController
     * @throws \Exception
     */
    public function detail(Request $request)
    {
        $rules = [
            'article_id' => 'required|integer'
        ];
        $data = $this->filterParams($request,$rules);

        if (!Auth::check()) {
            throw new \Exception('请先登录',ErrorCode::USER_HAS_NOT_LOGIN);
        }
        $article = ArticleModel::query()
            ->leftJoin('article_category', 'article_category.id','=','article.category_id')
            ->where('article.id',$data['article_id'])
            ->first();

        $article->created_at = date('Y-m-d H:i:s', $article->created_at);

        $this->setKeyContent($article);
        return $this->responseArray();
    }

    /**
     * @param Request $request
     * @return ArticleController
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getSupportList(Request $request)
    {
        $rules = [
            'category_id' => 'integer|nullable',
            'article_name' => 'string|nullable',
            'article_author' => 'string|nullable|max:20',
            'article_support' => 'in:2'
        ];
        $data = $this->filterParams($request,$rules);
        $articles = ArticleModel::getList(
            [
                ['article_support',2]
            ],
            false,
            ['article.id','article.article_name','article.created_at'],
            false,
            ['limit'=>10],
            ['offset' => 0]

        );

        foreach ($articles as &$item) {
            $item->created_at = date('Y-m-d', $item->created_at);
        }

        $this->setKeyContent($articles);
        return $this->responseArray();
    }

    /**
     * 文章详情页
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store($id)
    {
        return view('APP.article',['id' => $id]);
    }

    /**
     * 博客首页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('APP.index');
    }
}