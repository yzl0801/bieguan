<?php
declare (strict_types = 1);

namespace app;

use app\model\ConfigModel;
use app\model\LogBalanceModel;
use app\model\MemberModel;
use think\facade\Config;
use think\Service;

/**
 * 应用服务类
 */
class AppService extends Service
{
    public function register()
    {
        // 服务注册
        $this->app->bind('logic.log_balance', LogBalanceModel::class);
    }

    public function boot()
    {
        // 服务启动
    }
}
