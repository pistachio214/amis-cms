<?php

namespace plugin\cms\app\controller;

use support\Request;
use support\Response;

class AuthController
{
    public function login(Request $request): Response
    {
        $schema = json_encode([
            "type" => "page",
            "title" => "欢迎登录AMis Admin",
            "body" => [
                'type' => 'container',
                'style' => [
                    'position' => 'fixed',
                    'top' => 0,
                    'left' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'background' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                    'display' => 'flex',
                    'alignItems' => 'center',
                    'justifyContent' => 'center'
                ],
                'body' => [
                    'type' => 'container',
                    'style' => [
                        'width' => '400px',
                        'background' => '#ffffff',
                        'borderRadius' => '8px',
                        'boxShadow' => '0 4px 20px rgba(0, 0, 0, 0.15)',
                        'padding' => '40px 32px'
                    ],
                    'body' => [
                        'type' => 'form',
                        'title' => '',
                        'name' => 'loginForm',
                        "labelWidth" => 60,
                        "style" => [
                            "border" => "none",
                            "boxShadow" => "none",
                            "background" => "transparent"
                        ],
                        'api' => [
                            'method' => 'POST',
                            'url' => '/api/auth/login',
                            'data' => [
                                'username' => '${username}',
                                'password' => '${password}',
                                'remember' => '${remember}',
                            ]
                        ],
                        'messages' => [
                            'saveSuccess' => '登录成功！'
                        ],
                        'body' => [
                            [
                                'type' => 'container',
                                'body' => [
                                    'type' => 'tpl',
                                    'tpl' => '<div style="text-align: center; margin-bottom: 32px;"><h2 style="margin: 0 0 8px 0; color: #1f2d3d; font-size: 24px; font-weight: 600;">欢迎登录</h2><p style="margin: 0; color: #86909c; font-size: 14px;">请输入您的账号和密码</p></div>',
                                ]
                            ],
                            [
                                'type' => 'input-text',
                                'name' => 'username',
                                'label' => '用户名',
                                'required' => true,
                                'placeholder' => '请输入用户名或邮箱',
                                'clearable' => true,
                                'validations' => [
                                    'isRequired' => true,
                                ],
                                'validationErrors' => [
                                    'isRequired' => '请输入用户名'
                                ]
                            ],

                            [
                                'type' => 'input-password',
                                'name' => 'password',
                                'label' => '密码',
                                'required' => true,
                                'placeholder' => '请输入密码',
                                'clearable' => true,
                                'validations' => [
                                    'isRequired' => true,
                                    'minLength' => 6
                                ],
                                'validationErrors' => [
                                    'isRequired' => '请输入密码',
                                    'minLength' => '密码长度不能少于6位'
                                ]
                            ],

                            [
                                'type' => 'flex',
                                'style' => [
                                    'padding' => '0 0 0 20px',
                                    'display' => 'flex',
                                    'flexDirection' => 'row',
                                    'justifyContent' => 'space-between',
                                ],
                                'items' => [
                                    [
                                        'type' => 'checkbox',
                                        'name' => 'remember',
                                        'option' => '记住我',
                                        'value' => true,
                                        'mode' => 'inline',
                                    ],
                                    [
                                        'type' => 'button',
                                        'label' => '忘记密码？',
                                        'level' => 'link',
                                        'size' => 'sm',
                                        'actionType' => 'link',
                                        'link' => '/forgot-password',
                                    ],
                                ]
                            ],

                            [
                                'type' => 'button',
                                'label' => '登录',
                                'level' => 'primary',
                                'size' => 'lg',
                                'block' => true,
                                'actionType' => 'submit',
                                'className' => 'm-t-lg',
                            ],

                            [
                                'type' => 'divider',
                                'lineStyle' => 'dashed'
                            ],
                        ],
                        'mode' => 'horizontal',
                        'columnCount' => 1
                    ]
                ]
            ]
        ], JSON_UNESCAPED_UNICODE);

        return view('login', ['schema' => $schema]);
    }
}