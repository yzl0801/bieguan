<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/3/8
 * Time: 11:55
 */

namespace app\model;


use think\Model;

class AdminModel extends Model
{
    protected $table = 'admin';

    protected $autoWriteTimestamp = false;
}