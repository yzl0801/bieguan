<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/3/3
 * Time: 15:29
 */

namespace app\controller;


use app\BaseController;
use app\model\ConfigModel;
use app\model\LogBalanceModel;
use app\model\MemberModel;
use app\Request;
use think\facade\Db;
use think\Response;

class Member extends BaseController
{
    public function lists(Request $request)
    {
        $list = MemberModel::field("id,username,realname,mobile,sex,balance")
//            ->append(['show'])
            ->order("create_time desc")->select();
        return json([
            'code' => 0,
            'data' => $list,
        ]);
    }


    public function profile(Request $request, $id)
    {
        $m = MemberModel::find($id);
        $m->visible(['id','username','realname','mobile','sex','balance', 'remark']);

        return json([
            "code" => 0,
            "data" => $m
        ]);
    }


    public function create(Request $request)
    {
        $post = $request->post();
        $m = MemberModel::where('mobile', $post['mobile'])->find();
        if($m) {
            return json([
                "code" => 1,
                "msg" => "手机号重复"
            ]);
        }

        Db::startTrans();
        $data = $post;
        $data['balance'] = 0;
        $m = MemberModel::create($data);
        if($post['balance'] > 0) {
            app('logic.log_balance')->in($m->id, $post['balance'], LogBalanceModel::TYPE_CREATE, "新增用户直接充值");
            if(config('app.ratio') > 0) {
                app('logic.log_balance')->in($m->id, round((config('app.ratio') * $post['balance'] /100), 2), LogBalanceModel::TYPE_RECHARGE_PROMOTION, "账户充值赠送");
            }
        }
        Db::commit();

        return json([
            'code' => 0,
            'msg' => 'ok'
        ]);
    }

    public function update(Request $request, $id)
    {
        $post = $request->post();
        $m = MemberModel::where('id', '<>', $id)->where('mobile', $post['mobile'])->find();
        if($m) {
            return json([
                "code" => 1,
                "msg" => "手机号重复"
            ]);
        }
        $m = MemberModel::find($id);
        if(!$m) {
            return json([
                "code" => 1,
                "msg" => "查无此人"
            ]);
        }

        $m->save($post);

        return json([
            'code' => 0,
            'msg' => 'ok'
        ]);
    }


    /**
     * 删除会员
     *
     * @param Request $request
     * @param $id
     * @return \think\response\Json
     */
    public function delete(Request $request, $id)
    {
        MemberModel::destroy($id);

        return json([
            'code' => 0,
            'msg' => 'ok'
        ]);
    }

    public function accountChange(Request $request)
    {
        $post = $request->post();
        if($post['money'] <= 0) {
            return json([
                'code' => 1,
                'msg' => '充值金额小于0'
            ]);
        }
        $m = MemberModel::find($post['member_id']);
        if(!$m) {
            return json([
                'code' => 1,
                'msg' => '查无此人'
            ]);
        }

        switch ($request->param('type')) {
            case LogBalanceModel::TYPE_RECHARGE:
                app('logic.log_balance')->in($post['member_id'], $post['money'], LogBalanceModel::TYPE_RECHARGE, "账户充值");
                if(config('app.ratio') > 0) {
                    app('logic.log_balance')->in($post['member_id'], round((config('app.ratio') * $post['money'] /100), 2), LogBalanceModel::TYPE_RECHARGE_PROMOTION, "账户充值赠送");
                }
                break;
            case LogBalanceModel::TYPE_CONSUME:
            case LogBalanceModel::TYPE_OLD_GOODS:
            (new LogBalanceModel())->out($post['member_id'], $post['money'], LogBalanceModel::TYPE_CONSUME, "账户消费{$post['money']}元");
            break;
        }

        return json([
            'code' => 0,
            'msg' => 'ok'
        ]);
    }

    public function logs(Request $request, $id)
    {
        $list = LogBalanceModel::where('member_id', $id)->order('id desc')->select();

        return json([
            "code" => 0,
            "data" => $list
        ]);
    }
}