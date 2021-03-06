<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/3/6
 * Time: 10:10
 */

namespace app\controller;


use app\BaseController;
use app\model\ConfigModel;
use app\Request;

class Config extends BaseController
{

    public function get()
    {
        $list = array_column(ConfigModel::select()->toArray(), 'value', 'key');
        return json([
            'code' => 0,
            'data' => $list
        ]);
    }

    public function save(Request $request)
    {
        $post = $request->post();
        foreach($post as $key => $value) {
            $m = ConfigModel::find($key);
            if($m) {
                $m->save(['value' => $value]);
            }
            else {
                ConfigModel::create(['key'=>$key, 'value' => $value]);
            }
        }

        return json([
            'code' => 0
        ]);
    }
}