<?php
/**
 * Created by PhpStorm.
 * User: 79834
 * Date: 2020/3/10
 * Time: 0:51
 */

namespace Isesame\ThirdOauthLogin\Application;

interface ThirdApplication
{
    /**
     * get Authorization Code form third application service
     * @return mixed
     */
    public function getAuthorizationCode();

    /**
     * get Token form third application service
     * @param $code
     * @return mixed
     */
    public function getAccessToken($code);
}