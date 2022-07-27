<?php

declare(strict_types = 1);

namespace App\Kernel\Context;


use App\Kernel\Log\AppendRequestIdProcessor;
use Hyperf\Context\Context;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Engine\Coroutine as Co;
use Hyperf\Utils;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class Coroutine
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var StdoutLoggerInterface
     */
    protected $logger;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->logger    = $container->get(StdoutLoggerInterface::class);
    }

    public function create(callable $callable): int
    {
        $id = Utils\Coroutine::id();

        $coroutine = Co::create(function () use ($callable, $id) {
            try {
                Context::copy($id, [
                    ServerRequestInterface::class,
                    AppendRequestIdProcessor::REQUEST_ID,
                ]);
                call($callable);
            } catch (Throwable $e) {
                $this->logger->warning(throwable_format($e));
            }
        });

        try {
            return $coroutine->getId();
        } catch (Throwable $e) {
            $this->logger->warning(throwable_format($e));
            return -1;
        }
    }
}