<?php
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://doc.swoft.org
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Pool;

use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Pool;
use App\Pool\Config\GoodsPoolConfig;
use Swoft\Rpc\Client\Pool\ServicePool;

/**
 * the pool of goods service
 *
 * @Pool(name="goods")
 */
class GoodsServicePool extends ServicePool
{
    /**
     * @Inject()
     *
     * @var GoodsPoolConfig
     */
    protected $poolConfig;
}