<?php
/**
 * Created by PhpStorm.
 * User: 79834
 * Date: 2020/3/13
 * Time: 1:33
 */

namespace App\Http\Controllers\App;


use App\Helpers\ErrorCode;
use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use App\Models\UserAuthModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Isesame\ThirdOauthLogin\ThirdOauth;

class OauthController extends Controller
{
    public $userService;
    protected $config = [];

    /**
     * QQ登录注册用户类型
     */
    const QQ_IDENTITY_TYPE = 2;

    public function __construct(UserService $userService)
    {
        $this->config = [
            'oauthUrl' => config('oauth.oauthUrl'),
            'appId' => config('oauth.appId'),
            'appKey' => config('oauth.appKey')
        ];
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Isesame\ThirdOauthLogin\Exceptions\InvalidArgumentException
     * @throws \Isesame\ThirdOauthLogin\Exceptions\NoConfigAppException
     */
    public function actionIndex(Request $request)
    {
        $oauthService = new ThirdOauth('QQ');
        $this->config['oauthUrl'] .= 'authorize';
        $oauthService->setOptions($this->config);
        $callbackUrl = env('APP_URL') . 'oauth/qq/callback';

        return redirect($oauthService->getAuthorizationCode($callbackUrl));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Isesame\ThirdOauthLogin\Exceptions\InvalidArgumentException
     * @throws \Isesame\ThirdOauthLogin\Exceptions\NoConfigAppException
     */
    public function QQCallback(Request $request)
    {
        $code = $request->input('code');
        if (empty($code)) {
            throw new \Exception('非法请求！', ErrorCode::SYSTEM_ERROR);
        }

        $oauthService = new ThirdOauth('QQ');
        $this->config['oauthUrl'] .= 'token';
        $oauthService->setOptions($this->config);
        $callbackUrl = env('APP_URL') . 'oauth/qq/callback';

        $requestUrl = $oauthService->getAccessToken($code, $callbackUrl);
        $token = json_decode(postCurl($requestUrl, [],[],'GET'), true);
        dd($token);
        parse_str($token, $token);
        $accessToken = $token['access_token'];

        $cacheKey = md5('get:qq:info:by:token:' . $accessToken);
        $result = json_decode(Cache::pull($cacheKey),true);
        if (empty($result)) {
            $url = sprintf('https://graph.qq.com/oauth2.0/me?access_token=%s&unionid=1',$accessToken);
            $callback = postCurl($url,[],[],'GET');
//                $callback = file_get_contents($url);
            $result = substr($callback, 9,-3);
            Cache::add($cacheKey,$result,60);
            $result = json_decode($result,true);
        }

        // 判断用户是否存在
        $openId = $result['openid'];
        $user = app('userService')->getByUserName($openId,self::QQ_IDENTITY_TYPE);
        // 不存在就自动注册用户
        if (empty($user)) {
            $qqUserInfo = postCurl(
                sprintf('https://graph.qq.com/user/get_user_info?access_token=%s&oauth_consumer_key=%s&openid=%s',$token['access_token'], $user['client_id'], $user['openid']),
                [],
                [],
                'GET'
            );
//                $qqUserInfo = file_get_contents($getUserInfoApi);
            $qqUserInfo = json_decode($qqUserInfo, true);

            $user = [
                'identity_type' => self::QQ_IDENTITY_TYPE,
                'identifier' => $openId,
                'credential' => $accessToken,
                'nickname' => $qqUserInfo['nickname'],
                'head_pic' => $qqUserInfo['figureurl_qq']
            ];
            $userId = app('userService')->autoRegisterUser($user);
            $user = app('userService')->getByUserName($openId,self::QQ_IDENTITY_TYPE);
        } else {
            if ($user->credential != $accessToken) {
                throw new \Exception('账号有误！', ErrorCode::SYSTEM_ERROR);
            }
        }
        // 登录
        Auth::login($user);
        $userCookie = [
            'nickname' => $user->userInfo->nickname,
            'head_pic' => $user->userInfo->head_pic,
        ];
        return redirect('/index');
    }
}