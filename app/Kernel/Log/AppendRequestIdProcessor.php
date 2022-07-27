<?php

declare(strict_types = 1);

namespace App\Kernel\Log;

use Hyperf\Context\Context;
use Hyperf\Utils\Coroutine;
use Monolog\Processor\ProcessorInterface;

class AppendRequestIdProcessor implements ProcessorInterface
{

    public const REQUEST_ID = 'log.request.id';

    public function __invoke(array $record)
    {
        $record['extra']['request_id']   = Context::getOrSet(self::REQUEST_ID, uniqid());
        $record['extra']['coroutine_id'] = Coroutine::id();

        return $record;
    }
}