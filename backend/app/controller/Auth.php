<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/3/8
 * Time: 11:57
 */

namespace app\controller;


use app\BaseController;
use app\model\AdminModel;
use app\Request;

class Auth extends BaseController
{
    /**
     * 用户登录
     *
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function login(Request $request)
    {
        $post = $request->post();
        $m = AdminModel::where('username', $post['account'])->find();
        if(!$m) {
            return json([
                "code" => 1,
                "msg" => "管理员不存在"
            ]);
        }
        if($m->password != $post['password']) {
            return json([
                "code" => 1,
                "msg" => "密码错误"
            ]);
        }

        $result = app('logic.auth')->createToken($m->visible(['id'])->toArray());
        trace($result, 'info');

        return json([
            "code" => 0,
            "msg" => "登录成功",
            "data" => [
                "token" => $result['token'],
                "expire_time" => $result["exp"],
            ]
        ]);
    }
}