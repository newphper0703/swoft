<?php
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://doc.swoft.org
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Lib;

use Swoft\Core\ResultInterface;

/**
 * Interface GoodsInterface
 * @package App\Lib
 * @method ResultInterface deferGetStock(int $id)
 */
interface GoodsInterface
{
    public function getStock(int $id);

}