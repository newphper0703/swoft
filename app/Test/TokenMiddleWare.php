<?php
namespace App\Test;

use Swoft\Http\Message\Middleware\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Swoft\Bean\Annotation\Bean;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Stream\SwooleStream;
use Firebase\JWT\JWT;
use Swoole\Exception;



/**
 * @Bean("TokenMiddleWare")
 * Class GoodsMiddleWare
 * @package App\Test
 */
class TokenMiddleWare implements MiddlewareInterface
{

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
        $getToken = $request->query("token", false);
        if (!$getToken) {
            throw new \Exception("no token");
        }
        $result=(array)JWT::decode($getToken,"12345678",["HS256"]);

        foreach($result as $key=>$value)
        {
            $request=  $request->withAddedHeader("token_".$key,$value);
        }
        $response = $handler->handle($request);

        return $response;
    }
}