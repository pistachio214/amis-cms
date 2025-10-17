<?php

namespace plugin\cms\app\controller;

use support\Request;
use Webman\Http\Response;

class AuthController
{
    public function login(Request $request): Response
    {
        $schema = json_encode([
            "type" => "page",
            "title" => "用户管理 Demo",
            "body" => [
                [
                    "type" => "tpl",
                    "tpl" => "<h3>👋 欢迎使用 AMis + Webman</h3>"
                ],
                [
                    "type" => "form",
                    "title" => "示例表单",
                    "api" => "/api/submit",
                    "body" => [
                        ["type" => "input-text", "name" => "username", "label" => "用户名"],
                        ["type" => "input-email", "name" => "email", "label" => "邮箱"],
                        ["type" => "submit", "label" => "提交"]
                    ]
                ],
                [
                    "type" => "crud",
                    "api" => "/api/users",
                    "columns" => [
                        ["name" => "id", "label" => "ID"],
                        ["name" => "username", "label" => "用户名"],
                        ["name" => "email", "label" => "邮箱"]
                    ]
                ]
            ]
        ], JSON_UNESCAPED_UNICODE);

        return view('login', ['schema' => $schema]);
    }
}