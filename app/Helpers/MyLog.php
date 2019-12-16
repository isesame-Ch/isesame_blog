<?php
/**
 * Created by PhpStorm.
 * User: 79834
 * Date: 2019/12/17
 * Time: 0:24
 */

namespace App\Helpers;


use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

class MyLog
{
    // 所有的LOG都要求在这里注册
    const LOG_ERROR = 'error';
    const LOG_INTEREST = 'interest';
    const LOG_LARAVEL = 'laravel';

    private static $loggers = array();

    // 获取一个实例
    public static function getLogger($type = self::LOG_ERROR, $day = 0)
    {

        if (empty(self::$loggers[$type])) {
            $monoLog = new Logger($type);
            $handler = new RotatingFileHandler(
                sprintf(
                    '%s/logs/%s.log',
                    storage_path(),
                    $type
                ),
                $day
            );
            $handler->setFormatter(new LineFormatter(
                '%datetime% %message%' . PHP_EOL,
                'Y-m-d H:i:s u'
            ));

            self::$loggers[$type] = $monoLog->pushHandler($handler);

        }

        return self::$loggers[$type];
    }

    //普通错误日志（代码、数据库错误）
    public function errorLog($content, $type = self::LOG_ERROR, $day = 30)
    {
        $this->getLogger($type, $day)->error($content);
    }

    //兴趣事件日志（登录、退出）
    public function interestLog($content, $type = self::LOG_INTEREST, $day = 60)
    {
        $this->getLogger($type, $day)->info($content);
    }

    //普通日志
    public function laravelLog($content, $type = self::LOG_LUMEN, $day = 30)
    {
        $this->getLogger($type, $day)->info($content);
    }
}
