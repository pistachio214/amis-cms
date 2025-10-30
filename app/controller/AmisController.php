<?php

namespace plugin\cms\app\controller;

use plugin\cms\app\core\AmisTrait;
use support\Request;
use support\Response;

class AmisController
{
    use AmisTrait;

    public function index(Request $request): Response
    {
        return $this->setTitle('仪表盘')->view('home');
    }

}
