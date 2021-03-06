<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/3/3
 * Time: 15:27
 */

namespace app\model;


use think\Model;
use think\model\concern\SoftDelete;

class MemberModel extends Model
{
    use SoftDelete;

    protected $pk = 'id';

    protected $table = 'member';

    protected $autoWriteTimestamp = 'datetime';
}