<h1 align="center"> third_oauth_login </h1>

<p align="center"> simply build a third oauth login like QQ, github, wechat and so on.</p>


## Installing

```shell
$ composer require isesame/third_oauth_login -vvv
```

## Usage

```php
...
use Isesame\ThirdOauthLogin\ThirdOauth;
...

$appId = '101857153';   // APPID
$appKey = '22d50fa16429fb679516d2f837f16fa3';   // APPKEY
$oauthUrl = 'https://graph.qq.com/oauth2.0/authorize';  // 第三方oauth地址
$redirectUrl = 'xxx'; // 回调地址

$oauthService = new ThirdOauth('QQ');

$options = [
    'appId' => $appId,
    'appKey' => $appKey,
    'oauthUrl' => $oauthUrl
];
$oauthService->setOptions($options);

// 获取AuthorizationCode
$url = $oauthService->getAuthorizationCode($redirectUrl);
header('location:'.$url)
```
回调：
```php
...
// 在回调地址里再调用获取AccessToken的方法
...
use Isesame\ThirdOauthLogin\ThirdOauth;
...

$appId = '101857153';   // APPID
$appKey = '22d50fa16429fb679516d2f837f16fa3';   // APPKEY
$oauthUrl = 'https://graph.qq.com/oauth2.0/authorize';  // 第三方oauth地址
$redirectUrl = 'xxx'; // 回调地址

$oauthService = new ThirdOauth('QQ');

$options = [
    'appId' => $appId,
    'appKey' => $appKey,
    'oauthUrl' => $oauthUrl
];
$oauthService->setOptions($options);
$authorizationCode = $_POST['authorizationCode'];
$url = $oauthService->getAccessToken($authorizationCode,$redirectUrl);
...
```


## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/isesame/third_oauth_login/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/isesame/third_oauth_login/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT