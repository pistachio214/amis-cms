<?php

namespace plugin\cms\app\controller;

use support\Request;
use support\Response;

class IndexController
{
    public function index(): Response
    {
        return view('index/index', ['name' => 'cms']);
    }
}
