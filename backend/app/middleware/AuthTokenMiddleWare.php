<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/3/8
 * Time: 15:14
 */

namespace app\middleware;


use app\Request;
use think\Exception;

class AuthTokenMiddleWare
{
    public function handle(Request $request, \Closure $next)
    {
        if($request->isOptions()) {
            return $next($request);
        }

        $authInfo = null;
        $token = trim($request->header('Authori-zation')) ?: trim($request->header('Authorization'));
        if (stripos($token, 'Bearer') === 0) {
            $token = substr($token, 7);
        }

        try {
            $user = app('logic.auth')->parseToken($token);
        } catch (\Exception $e) {
            return json()->code(401);
        }

        app('logic.auth')->setUserId($user->id);

        return $next($request);
    }
}