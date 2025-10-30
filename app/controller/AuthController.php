<?php

namespace plugin\cms\app\controller;

use support\Request;
use support\Response;

class AuthController
{
    public function login(Request $request): Response
    {
        return view('login');
    }

    public function loginPost(Request $request)
    {
        dump($request->post());
        return json_encode(['code' => 200, 'message' => 'success13231312']);
    }
}