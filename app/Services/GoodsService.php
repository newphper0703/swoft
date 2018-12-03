<?php
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://doc.swoft.org
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Services;

use App\Lib\GoodsInterface;
use Swoft\Rpc\Server\Bean\Annotation\Service;
use Swoft\Core\ResultInterface;

/**
 * Class GoodsService
 * @package App\Services
 * @method ResultInterface deferGetStock(int $id)
 * @Service(version="1.0")
 */
class GoodsService implements GoodsInterface
{

    public function getStock(int $id)
    {
        return [$id];
    }

}