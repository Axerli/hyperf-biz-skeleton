<?php

declare(strict_types = 1);

use Hyperf\ExceptionHandler\Formatter\FormatterInterface;
use Hyperf\Utils\ApplicationContext;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

if (!function_exists('di')) {
    /**
     * @param string $id
     * @return mixed|ContainerInterface
     */
    function di(string $id = '')
    {
        $container = ApplicationContext::getContainer();
        if (!$id) {
            return $container;
        }

        return $container->get($id);
    }
}

if (!function_exists('throwable_format')) {
    /**
     * format throwable to string.
     * @param Throwable $throwable
     * @return string
     */
    function throwable_format(Throwable $throwable): string
    {
        return di(FormatterInterface::class)->format($throwable);
    }
}

if (!function_exists('event')) {
    /**
     * @param object $event
     */
    function event(object $event)
    {
        make(EventDispatcherInterface::class)->dispatch($event);
    }
}