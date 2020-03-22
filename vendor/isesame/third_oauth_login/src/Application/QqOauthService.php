<?php
/**
 * Created by PhpStorm.
 * User: 79834
 * Date: 2020/3/10
 * Time: 1:03
 */
namespace Isesame\ThirdOauthLogin\Application;

class QqOauthService extends ThirdApplicationOauth implements ThirdApplication
{
    /**
     * displayType
     * @var
     */
    const DISPLAY_PC_TYPE = 1;
    const DISPLAY_MOBILE_TYPE = 2;

    /**
     * @var string
     */
    protected $display;

    /**
     * QqOauth constructor.
     * @param $oauthUrl
     * @param $appId
     * @param $appKey
     * @param string $redirectUri
     */
    public function __construct($oauthUrl, $appId, $appKey, $redirectUri = '')
    {
        $this->oauthUrl = $oauthUrl;
        $this->appId = $appId;
        $this->appKey = $appKey;
        $this->redirectUri = $redirectUri ? : $_SERVER['SERVER_NAME'] . '/home';
    }

    public function getAuthorizationCode($state = 'ISESAME_STATE', $scope = '', $display = self::DISPLAY_PC_TYPE)
    {
        $requestParams = [
            'response_type' => 'code',
            'client_id' => $this->appId,
            'redirect_uri' => $this->redirectUri,
            'state' => $state,
        ];

        if ($scope) {
            $requestParams['scope'] = $scope;
        }

        if ($display == self::DISPLAY_MOBILE_TYPE) {
            $requestParams['display'] = 'mobile';
        }

        $requestUrl = $this->oauthUrl . '?' . http_build_query($requestParams);
        return $requestUrl;
    }

    public function getAccessToken($code)
    {
        $requestParams = [
            'grant_type' => 'authorization_code',
            'client_id' => $this->appId,
            'client_secret' => $this->appKey,
            'code' => $code,
            'redirect_uri' => $this->redirectUri,
        ];

        $requestUrl = $this->oauthUrl . '?' . http_build_query($requestParams);
        return $requestUrl;
    }
}