<?php

declare(strict_types = 1);

namespace App\Kernel\Utils;

use App\Kernel\Context\Coroutine as Go;
use Hyperf\Engine\Coroutine as Co;
use Hyperf\Engine\Exception\CoroutineDestroyedException;
use Hyperf\Engine\Exception\RunningInNonCoroutineException;

class Coroutine
{
    public static function id(): int
    {
        return Co::id();
    }

    public static function defer(callable $callable)
    {
        Co::defer($callable);
    }

    public static function sleep(float $seconds)
    {
        usleep((int) ($seconds * 1000 * 1000));
    }

    /**
     * @throws RunningInNonCoroutineException when running in non-coroutine context
     * @throws CoroutineDestroyedException when the coroutine has been destroyed
     */
    public static function parentId(?int $coroutineId = null): int
    {
        return Co::pid($coroutineId);
    }

    public static function create(callable $callable): int
    {
        return di()->get(Go::class)->create($callable);
    }

    public static function inCoroutine(): bool
    {
        return Co::id() > 0;
    }

}