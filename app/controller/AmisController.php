<?php

namespace plugin\cms\app\controller;

use support\Request;
use Webman\Http\Response;

class AmisController
{
    public function index(Request $request): Response
    {
        // AMis JSON Schema
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

        // 将 schema 转成 JSON 输出到 Blade 模板
        return view('amis', ['schema' => $schema]);
    }

}
