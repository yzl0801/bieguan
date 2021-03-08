<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/3/3
 * Time: 15:49
 */

namespace app\model;


use think\Exception;
use think\facade\Db;
use think\Model;

class LogBalanceModel extends Model
{
    protected $table = 'log_balance';

    protected $pk = 'id';

    protected $autoWriteTimestamp = 'datetime';

    const TYPE_RECHARGE = 1;
    const TYPE_RECHARGE_PROMOTION = 2;
    const TYPE_REFUND = 3;
    const TYPE_CREATE = 4;
    const TYPE_ADMIN_IN = 5;
    const TYPE_CONSUME = 51;
    const TYPE_OLD_GOODS = 52;
    const TYPE_ADMIN_OUT = 54;


    public function in($member_id, $money, $type, $desc = '')
    {
        if($money < 0) {
            throw new Exception("金额不能小于0", 1);
        }
        $user = MemberModel::lock(true)->find($member_id);

        Db::startTrans();
        $data = [];
        $data['member_id'] = $member_id;
        $data['type'] = $type;
        $data['description'] = $desc;
        $data['value'] = $money;
        $data['value_after'] = bcadd($user->balance, $money, 2);

        $user->balance = bcadd($user->balance, $money, 2);

        if(LogBalanceModel::create($data) && $user->save()) {
            Db::commit();
            return true;
        } else {
            Db::rollback();
            return false;
        }
    }


    public function out($member_id, $money, $type, $desc = '')
    {
        if($money < 0) {
            throw new Exception("金额不能小于0", 1);
        }

        Db::startTrans();
        $user = MemberModel::lock(true)->find($member_id);
        if(bcsub($user->balance, $money, 2) < 0) {
            Db::rollback();
            throw new Exception("账户余额不足", 1);
        }

        $data = [];
        $data['member_id'] = $member_id;
        $data['type'] = $type;
        $data['description'] = $desc;
        $data['value'] = -1 * $money;
        $data['value_after'] = bcsub($user->balance, $money, 2);

        $user->balance = bcsub($user->balance, $money, 2);

        if(LogBalanceModel::create($data) && $user->save()) {
            Db::commit();
            return true;
        } else {
            Db::rollback();
            return false;
        }
    }

    public function getTypeAttr($value)
    {
        return get_log_balance_type($value);
    }
}