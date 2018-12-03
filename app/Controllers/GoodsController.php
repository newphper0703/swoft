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
use App\Models\Logic\GoodsLogic;
use App\Test\MyAttachment;
use Swoft\App;
use Swoft\Bean\BeanFactory;
use Swoft\Db\Query;
use Swoft\Db\QueryBuilder;
use Swoft\Http\Message\Stream\SwooleStream;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Message\Server\Response;
use Swoft\Bean\Annotation\Strings;
use Swoft\Bean\Annotation\ValidatorFrom;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Bean\Annotation\Middlewares;
use App\Test\GoodsMiddleWare;
use App\Test\TokenMiddleWare;
use App\Middlewares\SomeMiddleware;
use App\Middlewares\CorsMiddleware;
use Swoft\Redis\Redis;

/**
 * @Controller("/goods")
 * @Middleware(class=\TokenMiddleWare::class)
 *
 *
 */
class GoodsController
{

    /*
     * @RequestMapping()
     */
    public function index(Request $request)
    {
        return $request->getHeaders();
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
    public function funcArgs(bool $bool, Request $request, int $bid, string $name, int $uid, Response $response): array
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
    public function testDel(int $id)
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
        $result = Goods::exist($id)->getResult();
        return $result;
        $result = Goods::query()->orderBy('id', QueryBuilder::ORDER_BY_DESC)->limit(2)->get()->getResult();
        return $result;
        $goods = Goods::findAll([['id', '>', 2]],['orderby' => ['id, num' => 'desc', 'sprice' => 'desc'], 'limit' => 10])->getResult()->toArray();

        return $goods;
        $goods = Goods::findOne(['id'=>$id], ['fields' => ['*']])->getResult();
        return $goods;
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
     * @RequestMapping(route="queryselect/{id}")
     * @param Request $request
     * @return array
     */
    public function queryselect(int $id)
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
     * @RequestMapping(route="newgoods")
     * @Strings(from=ValidatorFrom::POST, name="goods", min=3, max=50, default="null")
     * @param Request $request
     */
    public function newGoods(Request $request)
    {
        return $request->input('goods');
        return $request->getParsedBody();

    }

    /**
     * @Inject(name="goods")
     */
    public $goods;

    /**
    * @Inject(name="filterConfig")
    */
    public $filterConfig;


    /**
     * @Inject(name="config")
     */
    public $config;


    /**
     * @Inject()
     * @var \Swoft\Redis\Redis
     */
    private $redis;

    /**
     *
     * @RequestMapping(route="xx/{id}")
     *
     */
    public function xx(int $id)
    {
        //方式一
        //        $goods  = new GoodsLogic();
        //方式二
//        $goods = BeanFactory::getBean('goods');

        $this->filterConfig->discount = 0.75;
        return $this->config->get("goods.filterConfig.discount", "0.9");
        return $this->config->get("version", "0.9");
        return 'ok';
    }

    /**
     *
     * @RequestMapping(route="xxx/{id}")
     *
     */
    public function xxx(int $id)
    {
        //方式一
        //        $goods  = new GoodsLogic();
        //方式二
//        $goods = BeanFactory::getBean('goods');

        return Goods::findById($id)->getResult();
        //return $this->goods->filter(Goods::findById($id)->getResult());
    }

    /**
     *
     * @RequestMapping(route="xxx")
     *
     */
    public function getList()
    {
        //方式一
        //        $goods  = new GoodsLogic();
        //方式二
//        $goods = BeanFactory::getBean('goods');

        return Goods::findAll()->getResult();
        //return $this->goods->filter(Goods::findById($id)->getResult());
    }

    /**
     *
     * @RequestMapping(route="testMiddleware")
     * @Middlewares({
     *     @Middleware(class=SomeMiddleware::class),
     *     @Middleware(class=CorsMiddleware::class)
     * })
     *
     */
    public function testMiddleWare(Request $request)
    {
        $path = $request->getUri()->getPath();
        return $path;
    }


    /**
     *
     * @RequestMapping(route="/favicon")
     * @Middleware(class=SomeMiddleware::class)
     *
     *
     */
    public function favicon(Request $request)
    {
        $path = $request->getUri()->getPath();
        return $path;
    }

    /**
     *
     * @RequestMapping(route="redis")
     *
     *
     */
    public function redis()
    {
        $this->redis->set('name','liuz');
        $name = $this->redis->get('name');
        App::info('goods/redis', ['name' => $name]);
        return $name;
    }

    /**
     *
     * @RequestMapping(route="phpword")
     *
     *
     */
    public function testphpword()
    {

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
// Adding Text element to the Section having font styled by default...
        $section->addText(
            '"Learn from yesterday, live for today, hope for tomorrow. '
            . 'The important thing is not to stop questioning." '
            . '(Albert Einstein)'
        );

        /*
         * Note: it's possible to customize font style of the Text element you add in three ways:
         * - inline;
         * - using named font style (new font style object will be implicitly created);
         * - using explicitly created font style object.
         */

// Adding Text element with font customized inline...
        $section->addText(
            '"Great achievement is usually born of great sacrifice, '
            . 'and is never the result of selfishness." '
            . '(Napoleon Hill)',
            array('name' => 'Tahoma', 'size' => 10)
        );

// Adding Text element with font customized using named font style...
        $fontStyleName = 'oneUserDefinedStyle';
        $phpWord->addFontStyle(
            $fontStyleName,
            array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232', 'bold' => true)
        );
        $section->addText(
            '"The greatest accomplishment is not in never falling, '
            . 'but in rising again after you fall." '
            . '(Vince Lombardi)',
            $fontStyleName
        );

// Adding Text element with font customized using explicitly created font style object...
        $fontStyle = new \PhpOffice\PhpWord\Style\Font();
        $fontStyle->setBold(true);
        $fontStyle->setName('Tahoma');
        $fontStyle->setSize(13);
        $myTextElement = $section->addText('"Believe you can and you\'re halfway there." (Theodor Roosevelt)');
        $myTextElement->setFontStyle($fontStyle);

// Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('helloWorld.docx');

// Saving the document as ODF file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
        $objWriter->save('helloWorld.odt');

// Saving the document as HTML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        $objWriter->save('helloWorld.html');

    }

    /*
     * @RequestMapping(route="download")
     */
    public function testdownload(Response $response)
    {
        return new MyAttachment(BASE_PATH."/helloWorld.docx", "mytest.doc");

//        $fileName = BASE_PATH . "/helloWorld.docx";
//        $file = fopen($fileName, "r");
//        $response->withHeader('Content-type', 'application/octet-stream')
//            ->withHeader('Content-Disposition', 'attachment:filename=helloWorld.docx')
//            ->withBody(new SwooleStream(fread($file, filesize($fileName))));
    }

    /**
     * @RequestMapping(route="insertxx")
     */
    public function insertGetId()
    {
        $values = [
            'goods'  => 'name',
            'sprice'  => '7000',
            'num'  => 1,

        ];
        $result = Query::table(Goods::class)->insert($values)->getResult();
        return $result;
    }



}