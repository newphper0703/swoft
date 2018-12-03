<?php
namespace App\Controllers\Api;


use App\Exception\ParamException;
use App\Models\Entity\TobUser;
use Swoft\Db\Query;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Swoft\Bean\Annotation\Value;
use \Firebase\JWT\JWT;

/**
 * @Controller("/token")
 */
class TokenController
{
    /**
     * @RequestMapping(route="access_token",method={RequestMethod::GET})
     */
    function access_token(Request $request)
    {
        $uname=$request->query("uname",false);
        $usec=$request->query("usec",false);
        if(!$uname || !$usec)
            throw new ParamException("参数不全");
        $getUser=TobUser::findOne(["user_name"=>$uname,"user_password"=>$usec],['fields' => ['id', 'user_name']])->getResult();
        if($getUser){
            $token = [
                "iss" => "http://jtthink.com",
                "uname" => $getUser->getUserName(),
                "exp"=>time()+20
            ];

           $token= JWT::encode($token, "12345678");
         return ["token"=>$token];
        }
        else
            return ["token"=>""];
    }
    /**
     * @RequestMapping(route="verify",method={RequestMethod::GET})
     */
    function verify(Request $request)
    {
        $getToken=$request->query("token",false);
        $result=JWT::decode($getToken,"12345678",["HS256"]);
        return (array)$result;

    }


    /**
     * @RequestMapping(route="test",method={RequestMethod::GET})
     */
    function test(Request $request)
    {

        return "test";


    }


}