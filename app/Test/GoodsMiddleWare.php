<?php
namespace App\Test;


use App\Models\Entity\Goods;
use Swoft\Http\Message\Middleware\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Swoft\Bean\Annotation\Bean;
use Swoft\Bean\Annotation\Inject;
use App\Models\Logic\GoodsLogic;
use Swoft\Http\Message\Stream\SwooleStream;


/**
 * @Bean("goodsMiddleWare")
 * Class GoodsMiddleWare
 * @package App\Test
 */
class GoodsMiddleWare implements MiddlewareInterface
{
    /**
     * @Inject(name="goods")
     */
    public $goods;

    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler):ResponseInterface
    {
        $response = $handler->handle($request);
        $getAttr = $response->getAttribute('responseAttribute');
        /*if ($getAttr && $getAttr instanceof Goods) {
            $goods = $this->goods->filter($getAttr);
            return $response->withAttribute('responseAttribute', $goods);
        }*/
        if ($getAttr && $getAttr instanceof MyAttachment) {
            $file = fopen($getAttr->filePath, "r");
        $response->withHeader('Content-type', 'application/octet-stream')
            ->withHeader('Content-Disposition', 'attachment:filename='.$getAttr->fileName.'')
            ->withBody(new SwooleStream(fread($file, filesize($getAttr->filePath))));
        }
        return $response->withAddedHeader('name', 'lz');
    }
}