<?php

namespace plugin\cms\app\controller;

use plugin\cms\app\core\AmisCore;
use support\Request;
use support\Response;

class AmisController
{
    public function index(Request $request): Response
    {

        $core = new AmisCore();
        $data = $core->setTitle("amis 标题")
            ->setUsername('王老五(管理员)')
            ->setUserDropdown([
                'label' => '个人2中心',
                'actionType' => 'link',
                'link' => '/profile'
            ])
            ->setFooter('© 2025 企业管理系统 版权所有 | 技术支持: 123-456-7890')
            ->build();

        return $data;
    }

}
