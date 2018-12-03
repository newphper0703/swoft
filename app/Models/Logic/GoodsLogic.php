<?php
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://doc.swoft.org
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Models\Logic;

use App\Models\Entity\Goods;
use Swoft\Bean\Annotation\Bean;
use Swoft\Rpc\Client\Bean\Annotation\Reference;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Value;

/**
 *
 * @Bean("goods")
 */
class GoodsLogic
{
    /**
     * @Reference("user")
     *
     * @var \App\Lib\DemoInterface
     */
    private $demoService;

    /**
     * @Reference(name="user", version="1.0.1")
     *
     * @var \App\Lib\DemoInterface
     */
    private $demoServiceV2;


//    private $discount = 0.8;

    /**
     * @Inject(name="filterConfig")
     */
    public $filterConfig;

    /**
     * @Value(name="${config.goods.filterConfig.discount}")
     * @return array
     */
    public $discount;

    public function rpcCall()
    {
        return ['bean', $this->demoService->getUser('12'), $this->demoServiceV2->getUser('16')];
    }

    public function getUserInfo(array $uids)
    {
        $user = [
            'name' => 'boby',
            'desc' => 'this is boby'
        ];

        $data = [];
        foreach ($uids as $uid) {
            $user['uid'] = $uid;
            $data[] = $user;
        }

        return $data;
    }

    public function filter(Goods $goods)
    {
        if (!$goods) return null;
        return $goods->getSprice()*$this->discount;

//        return $goods->getSprice()*$this->filterConfig->discount;
    }


}