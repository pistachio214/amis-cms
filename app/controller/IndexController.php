<?php

namespace plugin\cms\app\controller;

use support\Request;

class IndexController
{

    public function index()
    {
        return view('index/index', ['name' => 'cms']);
    }

}
