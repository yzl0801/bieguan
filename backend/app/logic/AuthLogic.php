<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/3/8
 * Time: 14:33
 */

namespace app\logic;

use \Firebase\JWT\JWT;


class AuthLogic
{
    protected $user_id = 0;


    /**
     * @param $params
     * @return array
     */
    public function createToken($payload = [])
    {
        $host = app()->request->host();
        $time = time();

        $payload["iss"] = $host;
        $payload["aud"] = $host;
        $payload["iat"] = $time;
        $payload["nbf"] = $time;
        $payload["exp"] = strtotime('+3 days');
//        $payload["exp"] = strtotime('+30 seconds');
//        $params['jti'] = $params;
        $payload["token"] = JWT::encode($payload, config('jwt.key'));

        return array_intersect_key($payload, ["token"=>"", "exp"=>""]);
    }


    /**
     * @param $token
     * @return object
     */
    public function parseToken($token)
    {
        JWT::$leeway = 60; // $leeway in seconds
        $decoded = JWT::decode($token, config('jwt.key'), array('HS256'));

        return $decoded;
    }


    public function setUserId($id)
    {
        $this->user_id = $id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }
}