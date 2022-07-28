<?php

declare(strict_types = 1);

namespace App\Kernel\Http;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @method static getMessage(int $code)
 */
#[Constants]
class Code extends AbstractConstants
{
    /**
     * @Message("请求成功")
     */
    public const SUCCESS = 0;

    /**
     * @Message("请求失败")
     */
    public const ERROR = 1;
}