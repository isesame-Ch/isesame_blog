<?php
/**
 * Created by PhpStorm.
 * User: 79834
 * Date: 2020/3/10
 * Time: 1:00
 */
namespace Isesame\ThirdOauthLogin\Application;

class ThirdApplicationOauth
{
    /**
     * third service appId
     * @var
     */
    protected $appId;

    /**
     * third service appKey
     * @var
     */
    protected $appKey;

    /**
     * third service oauth url
     * @var
     */
    protected $oauthUrl;

    /**
     * redirectUri
     * @var
     */
    protected $redirectUri;

    /**
     * scope
     * @var
     */
    protected $scope;

    /**
     * state
     * @var
     */
    protected $state;
}