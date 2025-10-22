<?php

namespace plugin\cms\app\controller;

use plugin\cms\app\core\AmisCore;
use support\Request;
use Webman\Http\Response;

class AmisController
{
    public function index(Request $request): Response
    {
        $core = new AmisCore();

        return $core->setTitle("amis 标题")
            ->setUsername('王老五(管理员)')
            ->setFooter()
            ->setMenuNav([])
            ->build();
//        return view('amis');
    }

}
