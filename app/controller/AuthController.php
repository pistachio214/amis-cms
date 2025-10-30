<?php

namespace plugin\cms\app\controller;

use plugin\cms\app\exception\AmisException;
use support\Request;
use support\Response;

class AuthController
{
    public function login(Request $request): Response
    {
        return view('login');
    }

    public function loginPost(Request $request): Response
    {
        $username = $request->post('username');
        $password = $request->post('password');

        if (empty($username) || empty($password)) {
            throw new AmisException('账号或者密码不能为空');
        }

        if ($username != 'admin') {
            throw new AmisException('账号不正确');
        }

        if ($password != 'xiaofeng') {
            throw new AmisException('密码不正确');
        }

        return json(['code' => 200, 'data' => ['token' => md5('无边丝雨细如愁,朝来寒雨几回眸.')], 'message' => '登录成功,正在跳转...']);
    }
}