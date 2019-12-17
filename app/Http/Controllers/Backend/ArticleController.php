<?php
/**
 * Created by PhpStorm.
 * User: 79834
 * Date: 2018/8/1
 * Time: 16:22
 */

namespace App\Http\Controllers\Backend;


use App\Helpers\ErrorCode;
use App\Http\Controllers\Controller;
use App\Http\Services\ArticleCategoryService;
use App\Http\Services\ArticleService;
use App\Models\ArticleCategoryModel;
use App\Models\ArticleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ArticleController extends Controller
{
    
    public $articleService;

    public function __construct(ArticleService $articleService) {
        $this->articleService = $articleService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listShow()
    {
        return view('Backend.articleList');
    }

    /**
     * 文章列表
     * @param Request $request
     * @return ArticleController
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
                [
                    'article.id','article.article_name','article.article_author','article.article_describe',
                    'article.article_img','article.article_view','article.created_at','article.updated_at',
                    'article_category.name as category_name'
                ]
            )
        );

        foreach ($articles['data'] as &$item) {
            $item['created_at'] = date('Y-m-d H:i:s', $item['created_at']);
            $item['updated_at'] = date('Y-m-d H:i:s', $item['updated_at']);
        }

        $this->setKeyContent($this->listData($articles));
        return $this->responseArray();
    }

    /**
     * 删除文章
     * @param Request $request
     * @return ArticleController
     * @throws \Exception
     */
    public function delete(Request $request)
    {
        $rules = [
            'article_id' => 'required|integer',
        ];
        $data = $this->filterParams($request, $rules);

        $article = ArticleModel::find(Arr::pull($data,'article_id'));
        if (empty($article)) {
            throw new \Exception('没有这篇文章',ErrorCode::ARTICLE_ERROR);
        }
        $result = $article->delete();

        $this->setKeyContent($result);
        return $this->responseArray();
    }

    /**
     * 移除文章（物理删除）
     * @param Request $request
     * @return ArticleController
     * @throws \Exception
     */
    public function remove(Request $request)
    {
        $rules = [
            'article_id' => 'required|integer',
        ];
        $data = $this->filterParams($request, $rules);

        $article = ArticleModel::find(Arr::pull($data,'article_id'));
        if (empty($article)) {
            throw new \Exception('没有这篇文章',ErrorCode::ARTICLE_ERROR);
        }
        $result = $article->forceDelete();

        $this->setKeyContent($result);
        return $this->responseArray();
    }

    /**
     * 文章基础信息编辑
     * @param Request $request
     * @return ArticleController
     * @throws \Exception
     */
    public function edit(Request $request)
    {
        $rules = [
            'article_id' => 'required|integer',
            'article_name' => 'required|string',
            'article_author' => 'required|string',
            'category_id' => 'required|integer',
            'article_type' => 'required|in:1,2',
            'article_support' => 'required|in:1,2'
        ];
        $data = $this->filterParams($request, $rules);

        $article = ArticleModel::find(Arr::pull($data,'article_id'));
        if (empty($article)) {
            throw new \Exception('没有这篇文章',ErrorCode::ARTICLE_ERROR);
        }
        $data['updated_at'] = time();
        $result = $article->update($data);

        $this->setKeyContent($result);
        return $this->responseArray();
    }

    /**
     * 文章详情
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

        $article = ArticleModel::query()
            ->leftJoin('article_category', 'article_category.id','=','article.category_id')
            ->where('article.id',$data['article_id'])
            ->first();

        if (empty($article)) {
            throw new \Exception('没有这篇文章',ErrorCode::ARTICLE_ERROR);
        }
        $article->created_at = date('Y-m-d H:i:s', $article->created_at);

        $this->setKeyContent($article);
        return $this->responseArray();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('Backend.releaseArticle');
    }

    /**
     * 发布文章
     * @param Request $request
     * @return ArticleController
     * @throws \Exception
     */
    public function release(Request $request)
    {
        $rules = [
            'category_id' => 'required|integer',
            'article_name' => 'required|string',
            'article_author' => 'required|string|max:20',
            'article_describe' => 'required|string',
            'keywords_one' => 'required|string',
            'keywords_two' => 'string',
            'keywords_three' => 'string',
            'article_content' => 'required|string',
            'article_img' => 'string|nullable',
        ];
        $data = $this->filterParams($request, $rules);
        $article = new ArticleModel();
        $article->category_id = $data['category_id'];
        $article->article_name = $data['article_name'];
        $article->article_author = $data['article_author'];
        $article->article_describe = $data['article_describe'];
        $article->keywords_one = $data['keywords_one'];
        $article->keywords_two = $data['keywords_two'];
        $article->keywords_three = $data['keywords_three'];
        $article->article_content = $data['article_content'];
        if (Arr::has($data,'article_img')) {
            $article->article_img = $data['article_img'];
        }
        $article->created_at = time();
        $result = $article->save();
//        if (!$result) {
//            throw new \Exception('文章发布失败',ErrorCode::ARTICLE_RELEASE_ERROR);
//        }
        $this->setKeyContent($result);
        return $this->responseArray();
    }

    /**
     * 上传文章首页图片
     * @param Request $request
     * @return ArticleController
     * @throws \Exception
     */
    public function uploadPic(Request $request)
    {
        $rules = [
            'upload_pic' => 'required|file'
        ];
        $data = $this->filterParams($request, $rules);
        $file = $data['upload_pic'];
        $extension = $file->getClientOriginalExtension();

        if (!in_array($extension,['jpg','png','gif','jpeg'])){
            throw new \Exception('只能上传以jpg,png,gif,jpeg作后缀的图片哦~',ErrorCode::ARTICLE_PICTURE_ERROR);
        }
        $currentDate = Date('Ym',time());
        $file_path = 'uploads/article_img/'.$currentDate;
        $filename = md5('upload'.rand(1000,9999).microtime()). '.' .$extension;
        $file->move(public_path($file_path),$filename);

        $return = '/article_img/'.$currentDate.'/'.$filename;
        $this->setKeyContent($return);
        return $this->responseArray();
    }

    public function editShow($id)
    {
        return view('Backend.updateArticle',['id' => $id]);
    }

    /**
     * 分类管理列表页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function categoryShow()
    {
        return view('Backend.articleCategoryList');
    }

    /**
     * 分类列表
     * @param Request $request
     * @return ArticleController
     */
    public function getCategoryList(Request $request)
    {
        if ($request->input('page_size',false)) {
            $list = $this->articleService->getArticleCategoryList($request->input('page_size'));
            foreach ($list->items() as &$item) {
                $item->created_at = date('Y-m-d H:i:s', $item->created_at);
            }
            $return = $this->listData($this->obj2Array($list));
        } else {
            $return = $this->articleService->getArticleCategoryList();
        }
        $this->setKeyContent($return);
        return $this->responseArray();
    }

    /**
     * editormd上传图片
     * @param Request $request
     * @return array
     */
    public function editormdUpload(Request $request)
    {
        try {
            $file = $request->file('editormd-image-file');
            $extension = $file->getClientOriginalExtension();

            $currentDate = Date('Ym',time());
            $file_path = '/uploads/article_img/'.$currentDate;
            $filename = md5('upload'.rand(1000,9999).microtime()). '.' .$extension;
            $file->move(public_path($file_path),$filename);
        } catch (\Exception $e) {
            return [
                'success' => 2,
                'message' => '很抱歉，上传图片失败了',
                'url' => ''
            ];
        }
        return [
            'success' => 1,
            'message' => '成功啦',
            'url' => env('APP_URL').$file_path.'/'.$filename
        ];
    }

    /**
     * 添加文章分类
     * @param Request $request
     * @return ArticleController
     * @throws \Exception
     */
    public function addCategory(Request $request)
    {
        $rules = [
            'parent_id' => 'required|integer',
            'name' => 'required|string|max:20'
        ];
        $data = $this->filterParams($request, $rules);

        if ($data['parent_id'] != 0) {
            $parentCategory = ArticleCategoryModel::query()->where('id', $data['parent_id'])->first();
            if (empty($parentCategory)) {
                throw new \Exception('该父级分类不存在', ErrorCode::ARTICLE_PARENT_CATEGORY_ERROR);
            }
        }
        $result = ArticleCategoryModel::query()->create([
            'parent_id' => $data['parent_id'],
            'name' => $data['name'],
            'created_at' => time()
        ]);
        $this->setKeyContent($result);
        return $this->responseArray();
    }

    /**
     * 编辑文章分类
     * @param Request $request
     * @return ArticleController
     * @throws \Exception
     */
    public function editCategory(Request $request)
    {
        $rules = [
            'category_id' => 'required|integer',
            'parent_id' => 'required|integer',
            'name' => 'required|string|max:20'
        ];
        $data = $this->filterParams($request, $rules);

        if ($data['category_id'] == $data['parent_id']) {
            throw new \Exception('不能选择自己作为父级类型',ErrorCode::ARTICLE_CATEGORY_ERROR);
        }
        $category = ArticleCategoryModel::query()->where('id', $data['category_id'])->first();
        if (empty($category)) {
            throw new \Exception('该文章分类不存在', ErrorCode::ARTICLE_CATEGORY_ERROR);
        }
        if ($data['parent_id'] != 0) {
            $parentCategory = ArticleCategoryModel::query()->where('id', $data['parent_id'])->first();
            if (empty($parentCategory)) {
                throw new \Exception('该父级分类不存在', ErrorCode::ARTICLE_PARENT_CATEGORY_ERROR);
            }
        }
        $category->parent_id = $data['parent_id'];
        $category->name = $data['name'];
        $category->updated_at = time();
        $result = $category->save();

        $this->setKeyContent($result);
        return $this->responseArray();
    }

}