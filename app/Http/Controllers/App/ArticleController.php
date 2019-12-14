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
            'only' => ['show', 'create', 'store']
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
        if (!Auth::check()) {
            throw new \Exception('请先登录',ErrorCode::USER_HAS_NOT_LOGIN);
        }

        $articles = $this->obj2Array(ArticleModel::getList());

        foreach ($articles as &$item) {
            $item->created_at = date('Y-m-d H:i:s', $item->created_at);
            $item->updated_at = date('Y-m-d H:i:s', $item->updated_at);
        }

        $this->setKeyContent($articles);
        return $this->responseArray();
    }

    /**
     * @param Request $request
     * @return ArticleController
     * @throws \Illuminate\Validation\ValidationException
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