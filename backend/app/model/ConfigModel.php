<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/3/6
 * Time: 10:09
 */

namespace app\model;


use think\Model;

class ConfigModel extends Model
{
    protected $pk = 'key';

    protected $table = 'config';

    protected $autoWriteTimestamp = false;

}