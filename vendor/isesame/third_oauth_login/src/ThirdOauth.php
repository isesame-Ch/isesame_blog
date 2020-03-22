<?php
/**
 * Created by PhpStorm.
 * User: 79834
 * Date: 2020/3/10
 * Time: 0:39
 */
namespace Isesame\ThirdOauthLogin;

use Isesame\ThirdOauthLogin\Application\QqOauthService;
use Isesame\ThirdOauthLogin\Exceptions\InvalidArgumentException;
use Isesame\ThirdOauthLogin\Exceptions\NoConfigAppException;

class ThirdOauth
{
    public $thirdApplicationType = [
        'QQ','WECHAT','GITHUB','WEIBO'
    ];

    /**
     * @var
     */
    protected $thirdApplication;

    /**
     * @var
     */
    protected $oauthUrl;

    /**
     * @var
     */
    protected $appId;

    /**
     * @var
     */
    protected $appKey;

    /**
     * ThirdOauthLogin constructor.
     * @param $thirdType
     * @throws InvalidArgumentException
     */
    public function __construct($thirdType)
    {
        if (!in_array($thirdType, $this->thirdApplicationType)) {
            throw new InvalidArgumentException(sprintf('Invalid type value(%s):',implode('/',$this->thirdApplicationType)) . $thirdType, 4001);
        }

        $this->thirdApplication = $thirdType;
    }

    /**
     * @param $options
     * @throws InvalidArgumentException
     */
    public function setOptions($options)
    {
        if (!array_key_exists('oauthUrl', $options) || !array_key_exists('appId', $options) || !array_key_exists('appKey', $options)) {
            throw new InvalidArgumentException('Invalid options : please set oauthUrl, appId, appKey', 4002);
        }

        $this->oauthUrl = $options['oauthUrl'];
        $this->appId = $options['appId'];
        $this->appKey = $options['appKey'];
    }

    /**
     * @param string $redirectUri
     * @param string $state
     * @param string $scope
     * @param $display
     * @return mixed|string
     * @throws NoConfigAppException
     */
    public function getAuthorizationCode($redirectUri = '', $state = 'ISESAME_STATE', $scope = '', $display = 1)
    {
        switch ($this->thirdApplication) {
            case 'QQ':
                $oauthService = new QqOauthService($this->oauthUrl, $this->appId, $this->appKey, $redirectUri);
                break;
            default :
                throw new NoConfigAppException('You have not config this application oauth', 4003);
        }

        return $oauthService->getAuthorizationCode($state, $scope, $display);
    }

    /**
     * @param $authorizationCode
     * @param string $redirectUri
     * @return mixed|string
     * @throws NoConfigAppException
     */
    public function getAccessToken($authorizationCode,$redirectUri = '')
    {
        switch ($this->thirdApplication) {
            case 'QQ':
                $oauthService = new QqOauthService($this->oauthUrl, $this->appId, $this->appKey, $redirectUri);
                break;
            default :
                throw new NoConfigAppException('You have not config this application oauth', 4003);
        }

        return $oauthService->getAccessToken($authorizationCode);
    }
}