<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $validateMessages = [
        'required' => ':attribute 不能为空',
        'max' => ':attribute 超出允许最大值',
        'min' => ':attribute 超出允许最小值',
        'in' => ':attribute 无效',
        'numeric' => ':attribute 须要为数值',
        'array' => ':attribute 期望值为数组',
        'date_format' => ':attribute 时间格式为 2017-02-07',
    ];

    private $statusCode = 200;
    private $code = 0;
    private $message = 'success';
    private $content;
    private $contentEncrypt;

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode = 0)
    {
        $this->statusCode = (int)$statusCode;
        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code = 0)
    {
        $this->code = (int)$code;
        return $this;
    }

    public function getMessage()
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'content' => $this->content ? $this->content : '',
            'contentEncrypt' => $this->contentEncrypt ? $this->contentEncrypt : ''
        ];
    }

    public function setMessage($message = '')
    {
        $this->message = trim($message);
        return $this;
    }

    public function setError($message = '', $code = '')
    {
        $this->setMessage($message)->setCode($code);
        return $this;
    }

    public function setAllContent( $value = '')
    {

        $this->content = $value;

        return $this;
    }

    public function setContent($key = '', $value = '')
    {
        if (!$key) {
            return $this;
        }
        $this->content[$key] = $value;

        return $this;
    }

    public function setKeyContent( $value = '')
    {
        $this->content = $value;
        return $this;
    }

//    public function response()
//    {
//        return response()
//            ->json($this->getMessage())
//            ->setEncodingOptions(
//                env('APP_ENV') == 'prod'
//                    ? JSON_FORCE_OBJECT
//                    : JSON_FORCE_OBJECT
//                    | JSON_UNESCAPED_UNICODE
//                    | JSON_UNESCAPED_SLASHES
//                    | JSON_PRETTY_PRINT
//            )
//            ->withHeaders([
//                'Access-Control-Allow-Origin' => '*'
//            ]);
//    }
    public function responseArray()
    {

        return response()
            ->json($this->getMessage())
            ->setEncodingOptions(
                env('APP_ENV') == 'prod'
                    ? JSON_OBJECT_AS_ARRAY
                    : JSON_OBJECT_AS_ARRAY
                    | JSON_UNESCAPED_UNICODE
                    | JSON_UNESCAPED_SLASHES
                    | JSON_PRETTY_PRINT
            );
//			->withHeaders([
//				'Access-Control-Allow-Origin' => '*'
//			]);


    }

    public function isLimitRequest($sn = '' , $time = 5){
        $postData = isset($_POST)?$_POST:array('sn' => $sn);
        $str = $_SERVER['SERVER_NAME'].http_build_query($postData);
        $str = md5($str);
        $requestData = Cache::get($str);
        if (!empty($requestData)){
            throw new \Exception(DO_NOT_REPEAT_COMMIT_DESC , DO_NOT_REPEAT_COMMIT);
        }
        Cache::add($str , $str , Carbon::now()->addSeconds($time));
        return true;
    }

    /**
     * 过滤验证请求参数
     * @param Request $request
     * @param $rules
     * @param bool $special_treatment
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function filterParams(Request $request, $rules, $special_treatment = true)
    {
        $this->validate(
            $request,
            $rules,
            $this->validateMessages
        );

        $params = $request->only(array_keys($rules));
        $params = array_filter($params, function($value) use ($special_treatment) {
            return is_array($value) || $special_treatment && (string)$value === '0' || $value == true;
        }, ARRAY_FILTER_USE_BOTH);

        return $params;
    }

    /**
     * @param $obj
     * @return mixed
     */
    public function obj2Array($obj)
    {
        return json_decode(json_encode($obj), true);
    }

    /**
     * @param $list
     * @return array
     */
    public function listData($list)
    {
        return [
            'list' => $list['data'],
            'current_page' => $list['current_page'],
            'total_page' => $list['last_page'],
            'page_size' => $list['per_page'],
            'total' => $list['total']
        ];
    }
}
