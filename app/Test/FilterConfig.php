<?php
namespace App\Test;

use Swoft\Bean\Annotation\Bean;
use Swoft\Rpc\Client\Bean\Annotation\Reference;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Value;

/**
 *
 * @Bean("filterConfig")
 */
class FilterConfig
{

    public $discount = 0.7;
}