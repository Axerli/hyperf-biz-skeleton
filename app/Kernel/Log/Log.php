<?php

declare(strict_types = 1);

namespace App\Kernel\Log;

use Hyperf\Logger\LoggerFactory;

/**
 * @method static emergency($message, array $context = [])
 * @method static alert($message, array $context = [])
 * @method static critical($message, array $context = [])
 * @method static error($message, array $context = [])
 * @method static warning($message, array $context = [])
 * @method static notice($message, array $context = [])
 * @method static info($message, array $context = [])
 * @method static debug($message, array $context = [])
 * @method static log($level, $message, array $context = [])
 */
class Log
{
    /**
     * @param string $name
     * @param string $group
     * @return mixed|\Psr\Log\LoggerInterface
     */
    public static function logger(string $name = 'app', string $group =  'default')
    {
        return di(LoggerFactory::class)->get($name, $group);
    }

    /**
     * @param string $group
     * @return mixed|\Psr\Log\LoggerInterface
     */
    public static function group(string $group = 'default', string $name = 'app')
    {
        return self::logger($name, $group);
    }

    public static function __callStatic(string $method, $arguments)
    {
        return self::logger()->{$method}(...$arguments);
    }
}