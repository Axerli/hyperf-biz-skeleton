<?php

declare(strict_types = 1);

namespace App\Kernel\Http;

use Hyperf\Context\Context;
use Hyperf\HttpMessage\Exception\HttpException;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

class Response
{
    use PaginatorTrait;

    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * @var ResponseInterface
     */
    protected ResponseInterface $response;

    /**
     * Response constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->response = $container->get(ResponseInterface::class);
    }

    public function success(?string $message = null, array $data = []): PsrResponseInterface
    {
        return $this->response->json([
            'status'  => Code::SUCCESS,
            'message' => $message ?? Code::getMessage(Code::SUCCESS),
            'data'    => $data,
        ]);
    }

    public function error(int $code = Code::ERROR, ?string $message = null): PsrResponseInterface
    {
        return $this->response->json([
            'status'  => $code,
            'message' => $message ?? Code::getMessage($code),
        ]);
    }

    public function handleException(HttpException $httpException): PsrResponseInterface
    {
        return $this->response()
            ->withStatus($httpException->getStatusCode())
            ->withBody(new SwooleStream($httpException->getMessage()));
    }

    /**
     * @return PsrResponseInterface
     */
    protected function response(): PsrResponseInterface
    {
        return Context::get(PsrResponseInterface::class);
    }
}