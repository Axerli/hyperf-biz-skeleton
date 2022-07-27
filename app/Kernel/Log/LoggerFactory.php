<?php

declare(strict_types = 1);

namespace App\Kernel\Log;

class LoggerFactory
{
    public function __invoke()
    {
        return di(\Hyperf\Logger\LoggerFactory::class)->make();
    }
}