<?php

declare(strict_types = 1);

namespace App\Kernel\Http;

use Closure;
use Hyperf\Paginator\LengthAwarePaginator;
use Hyperf\Utils\Collection;
use Psr\Http\Message\ResponseInterface;

trait PaginatorTrait
{
    /**
     * @param LengthAwarePaginator|Collection $paginator
     * @param Closure|null                    $callback
     * @param array                           $append
     * @return ResponseInterface
     */
    public function paginator(LengthAwarePaginator $paginator, ?Closure $callback = null, array $append = []): ResponseInterface
    {
        $total = $paginator->total();
        $page  = $paginator->currentPage();
        $size  = $paginator->perPage();
        $pages = $paginator->lastPage();

        if ($callback instanceof Closure) {
            $list = $paginator->map($callback)->values();
        }
        else {
            $list = $paginator->values();
        }

        return $this->success('获取成功', array_merge([
            'list'       => $list,
            'pagination' => compact('total', 'page', 'size', 'pages'),
        ], $append));
    }
}