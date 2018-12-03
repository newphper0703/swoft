<?php
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://doc.swoft.org
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Controllers;

use App\Models\Entity\Goods;
use App\Models\Entity\Student;
use Swoft\Db\Db;
use Swoft\Db\Query;
use Swoft\Db\QueryBuilder;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Message\Server\Response;

/**
 * @Controller("/test")
 */
class TestController
{

    /*
     * @RequestMapping()
     */
    public function index()
    {

        return 'test.index';

    }

    /**
     * @RequestMapping(route="test")
     */
    public function test()
    {
        return 'test.test';
    }

    /**
     * @RequestMapping(route="user/{uid}/book/{bid}/{bool}/{name}")
     */
    public function funcArgs(bool $bool, Request $request, int $bid, string $name, int $uid, Response $response)
    {

        return [$bid, $uid, $bool, $name, \get_class($request), \get_class($response)];
    }

    /**
     * @RequestMapping(route="/param/{name}")
     * @param Request $request
     * @return array
     */
    public function param(Request $request)
    {
        $get = $request->query();
        $getName = $request->query('name', 'defaultGetName');
        $post = $request->post();
        $postName = $request->post('name', 'defaultPostName');
        $inputs = $request->input();
        $inputName = $request->input('name', 'defaultInputName');

        return compact('get', 'getName', 'post', 'postName', 'inputs', 'inputName');
    }

    /**
     * @RequestMapping(route="insert", method={RequestMethod::POST,RequestMethod::GET})
     * @param Request $request
     * @return int
     */
    public function testInsert()
    {
        $goods = new Goods();
        $goods->setNum(1);
        $goods->setSprice(5000);
        $goods->setGoods('测试商品');
        $id = $goods->save()->getResult();
        return $id;


    }

    /**
     * @RequestMapping(route="del/{id}", method={RequestMethod::POST,RequestMethod::PUT})
     * @param Request $request
     * @return int
     */
    public function testDel( $id)
    {
        $goods = Goods::findById($id)->getResult();
        $result = $goods->delete()->getResult();
        return $result;
    }

    /**
     * @RequestMapping(route="update/{id}/{goods}", method={RequestMethod::POST,RequestMethod::PUT})
     * @param Request $request
     * @return int
     */
    public function testUpdate(int $id, string $goods)
    {
        $result = Goods::updateOne(['goods' => $goods], ['id' => $id])->getResult();
        return $result;
    }

    /**
     * @RequestMapping(route="select/{id}", method=RequestMethod::GET)
     * @param Request $request
     * @return array
     */
    public function testSelect(int $id)
    {
        $count  = Goods::count('id', ['num', '>', 1])->getResult();
        return $count;
//        $result = Goods::exist($id)->getResult();
//        return $result;
//        $result = Goods::query()->orderBy('id', QueryBuilder::ORDER_BY_DESC)->limit(2)->get()->getResult();
//        return $result;
//        $goods = Goods::findAll([['id', '>', 2]],['orderby' => ['id, num' => 'desc', 'sprice' => 'desc'], 'limit' => 10])->getResult()->toArray();
//
//        return $goods;
//        $goods = Goods::findOne(['id'=>$id], ['fields' => ['*']])->getResult();
//        return $goods;
    }

    /**
     * @RequestMapping(route="queryinsert", method=RequestMethod::POST)
     * @param Request $request
     * @return array
     */
    public function queryInsert()
    {
//        $values = [
//            'goods' => '12222',
//            'sprice' => 10000,
//            'num' => 1
//        ];
//        $result = Query::table(Goods::class)->insert($values)->getResult();
//        return $result;
        $values = [
            [
                'goods' => '12222',
                'sprice' => 10000,
                'num' => 1
            ],
            [
                'goods' => '22222',
                'sprice' => 8000,
                'num' => 3
            ]
        ];
        $result = Query::table(Goods::class)->batchInsert($values)->getResult();
        return $result;
    }

    /**
     * @RequestMapping(route="querydel/{id}", method={RequestMethod::POST,RequestMethod::PUT})
     * @param Request $request
     * @return array
     */
    public function querydel(int $id)
    {
        $result = Query::table(Goods::class)->where('id', $id)->delete()->getResult();
        return $result;

    }

    /**
     * @RequestMapping(route="queryselect")
     * @param Request $request
     * @return array
     */
    public function queryselect()
    {
        $result = Query::table(Goods::class)->orderBy('id, sprice','desc')->get()->getResult();
        return $result;

    }

    /**
     * @RequestMapping(route="queryupdate/{id}")
     * @param Request $request
     * @return array
     */
    public function queryupdate(int $id)
    {
        $result = Query::table(Goods::class)->where('id', $id)->update(['goods' => '14rrr'])->getResult();
        return $result;

    }

    /**
     * @RequestMapping(route="query")
     * @param Request $request
     * @return array
     */
    public function query(int $id)
    {
        $return  = [];
        $result = Query::table(Goods::class)->count('id', 'count')->getResult();
        $return['count'] = $result;
        $sprice = Query::table(Goods::class)->sum('sprice', 'sumsprice')->getResult();
        $return['sprice'] = $sprice;
        $maxNum = Query::table(Goods::class)->max('num')->getResult();
        $return['maxNum'] = $maxNum;
        $minNum = Query::table(Goods::class)->min('num')->getResult();
        $return['minNum'] = $minNum;
        $avgNum = Query::table(Goods::class)->avg('num')->getResult();
        $return['avgNum'] = $avgNum;

        return $return;
    }

    /**
     * @RequestMapping()
     * @param Request $request
     * @return array
     */
    public function changedb()
    {
        $data = [
            'name' => 'liuzhi',
            'age' => 18,
            'sex' => 1
        ];
        $goods = Query::table(Goods::class)->selectDb('test_tob')->where('id', 5)->get()->getResult();
        $studentId = Query::table(Student::class)->selectDb('test')->insert($data)->getResult();

        return compact('goods', 'studentId');

    }

    /**
     * @RequestMapping(route('transaction/{id}'))
     * @param Request $request
     * @return array
     */
//    public function transaction(int $id)
//    {
//
//       Db::beginTransaction();
//
//       $insertgoods = Db::query('insert into goods(goods, sprice, num) values ("iphone xs max", 10999, 2)')->getResult();
//       $updateGoods = Db::query('update goods set name = "iphone xr" where id = '.$id)->getResult();
//       $delGoods = Db::query('delete from goods where id = 14')->getResult();
//
//       Db::commit();
//
//    }

    /**
     * @RequestMapping()
     * @View(template="test/index")
     *
     */
//    public function view()
//    {
//        return 'ffff';
//        $data = [
//            'name' => 'test.view',
//            'content' => '此处是内容'
//
//        ];
//        return view('test/index', $data);
//
//    }
}