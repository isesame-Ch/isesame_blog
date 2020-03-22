<?php
/**
 * Created by PhpStorm.
 * User: 79834
 * Date: 2020/3/13
 * Time: 1:33
 */

namespace App\Http\Controllers\App;


use App\Http\Controllers\Controller;
use App\Models\UserAuthModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Isesame\ThirdOauthLogin\ThirdOauth;

class OauthController extends Controller
{
    protected $config = [];

    public function __construct()
    {
        $this->config = [
            'oauthUrl' => config('oauth.oauthUrl'),
            'appId' => config('oauth.appId'),
            'appKey' => config('oauth.appKey')
        ];
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
        if (!empty($code)) {
            $oauthService = new ThirdOauth('QQ');
            $this->config['oauthUrl'] .= 'token';
            $oauthService->setOptions($this->config);
            $callbackUrl = env('APP_URL') . 'oauth/qq/callback';

            return redirect($oauthService->getAccessToken($code, $callbackUrl));
        }
        $accessToken = $request->input('access_token');
        $expiresTime = $request->input('expires_in');
//        $refreshToken = $request->input('refresh_token');
        $cacheKey = md5('oauth_token:' . $accessToken);
        $result = Cache::pull($cacheKey);
        if (empty($result)) {
            $result = ''; // todo 获取用户信息
        }

        // 判断用户是否存在
        $openId = $result[''];
        $user = UserAuthModel::query()->where(['identifier' => $openId, 'identity_type' => 2]);
        // 不存在就自动注册用户
        if (empty($user)) {

        }
        // 登录
        Auth::login($user);
        $userCookie = [
            'nickname' => '',
            'head_pic' => '',
        ];
        cookie('user', json_encode($userCookie), 180);
        return redirect('/index');
    }
}