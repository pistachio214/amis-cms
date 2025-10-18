<?php

namespace plugin\cms\app\controller;

use support\Request;
use Webman\Http\Response;

class AmisController
{
    public function index(Request $request): Response
    {
        // 将 schema 转成 JSON 输出到 Blade 模板
        return view('amis');
    }

}
