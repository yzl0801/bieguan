<?php
// 应用公共文件
function get_code($list, $type, $all = false) {
    if($all){
        return $list;
    }
    return $list[$type];
}

function get_log_balance_type($type, $all = false){
    $list = array(
        \app\model\LogBalanceModel::TYPE_RECHARGE => '充值' ,
        \app\model\LogBalanceModel::TYPE_RECHARGE_PROMOTION => '充值赠送' ,
        \app\model\LogBalanceModel::TYPE_REFUND => '退款' ,
        \app\model\LogBalanceModel::TYPE_CREATE => '新增用户直接设置' ,
        \app\model\LogBalanceModel::TYPE_CONSUME => '休闲消费' ,
        \app\model\LogBalanceModel::TYPE_OLD_GOODS => '古物文玩' ,
    );
    return get_code($list, $type, $all);
}
