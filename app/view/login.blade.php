<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>{{ '登录 | '.\plugin\cms\app\core\Config::APP_NAME }}</title>

    <!-- 引入 AMis SDK 核心样式 -->
    <link rel="stylesheet" href="{{ cms_asset('amis/cxd.css') }}"/>
    <!-- 引入 辅助样式 -->
    <link rel="stylesheet" href="{{ cms_asset('amis/helper.css') }}"/>
    <!-- 引入 icon 样式 -->
    <link rel="stylesheet" href="{{ cms_asset('amis/icon/iconfont.css') }}"/>

    <!-- 引入自定义样式 -->
    <link rel="stylesheet" href="{{ cms_asset('css/style.css') }}"/>
</head>
<body>
<div id="amis-root" style="height:100vh;"></div>
</body>
<script src='{{ cms_asset('amis/sdk.js') }}'></script>
<script src='{{ cms_asset('amis/rest.js') }}'></script>
<script>
    window.onload = function () {
        const amisEnv = {
            // 全局请求适配器
            requestAdaptor: (api) => {
                // 获取 token
                const token = localStorage.getItem('auth_token');

                if (token) {
                    // 添加 Authorization header
                    if (!api.headers) {
                        api.headers = {};
                    }
                    api.headers['Authorization'] = `Bearer ${token}`;
                }

                // 添加其他公共配置
                api.headers = {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    ...api.headers
                };

                return api;
            },

            // 全局响应适配器
            responseAdaptor: (api, response) => {
                console.log('API配置:', api);
                console.log('原始响应:', response);
                // 统一处理认证失败
                if (response.code === 401) {
                    localStorage.removeItem('auth_token');
                    window.location.href = '/cms/login';
                    return {
                        status: 401,
                        msg: '认证失败，请重新登录'
                    };
                }

                // 适配常见的后端响应格式
                if (response && typeof response.code !== 'undefined') {
                    return {
                        code: response.code,
                        status: response.code === 200 ? 0 : response.code,
                        defaultMsg: 'loading....',
                        msg: response.message,
                        msgTimeout: 1500,
                        data: response.data || {}
                    };
                }

                return response;
            },
        };

        const schema = {
            "type": "page",
            "title": "欢迎登录AMis Admin",
            "body": {
                "type": "container",
                "style": {
                    "position": "fixed",
                    "top": 0,
                    "left": 0,
                    "right": 0,
                    "bottom": 0,
                    "background": "linear-gradient(135deg, #667eea 0%, #764ba2 100%)",
                    "display": "flex",
                    "alignItems": "center",
                    "justifyContent": "center"
                },
                "body": {
                    "type": "container",
                    "style": {
                        "width": "400px",
                        "background": "#ffffff",
                        "borderRadius": "8px",
                        "boxShadow": "0 4px 20px rgba(0, 0, 0, 0.15)",
                        "padding": "40px 32px"
                    },
                    "body": {
                        "type": "form",
                        "title": "",
                        "name": "loginForm",
                        "labelWidth": 60,
                        "style": {"border": "none", "boxShadow": "none", "background": "transparent"},
                        "api": {
                            "method": "POST",
                            "url": "/cms/auth/login",
                            "data": {
                                "username": "${username}",
                                "password": "${password}",
                                "remember": "${remember}"
                            },
                        },
                        "onEvent": {
                            "submitSucc": {
                                "actions": [
                                    {
                                        "actionType": "custom",
                                        "script": "const apiResult = event.data?.result || event.data?.responseData || event.data; console.log('API结果:', apiResult); if (apiResult && apiResult.status === 0) { localStorage.setItem('auth_token', apiResult.data.token); setTimeout(() => { location.href = '/cms/index'; }, 1000); }"
                                    }
                                ]
                            }
                        },
                        "body": [{
                            "type": "container",
                            "body": {
                                "type": "tpl",
                                "tpl": "<div style='text-align: center; margin-bottom: 32px;'><h2 style='margin: 0 0 8px 0; color: #1f2d3d; font-size: 24px; font-weight: 600;'>欢迎登录 {!! \plugin\cms\app\core\Config::APP_NAME !!}</h2><p style='margin: 0; color: #86909c; font-size: 14px;'>请输入您的账号和密码</p></div>"
                            }
                        }, {
                            "type": "input-text",
                            "name": "username",
                            "label": "用户名",
                            "required": true,
                            "placeholder": "请输入用户名或邮箱",
                            "clearable": true,
                            "validations": {"isRequired": true},
                            "validationErrors": {"isRequired": "请输入用户名"}
                        }, {
                            "type": "input-password",
                            "name": "password",
                            "label": "密码",
                            "required": true,
                            "placeholder": "请输入密码",
                            "clearable": true,
                            "validations": {"isRequired": true, "minLength": 6},
                            "validationErrors": {"isRequired": "请输入密码", "minLength": "密码长度不能少于6位"}
                        }, {
                            "type": "flex",
                            "style": {
                                "padding": "0 0 0 20px",
                                "display": "flex",
                                "flexDirection": "row",
                                "justifyContent": "space-between"
                            },
                            "items": [{
                                "type": "checkbox",
                                "name": "remember",
                                "option": "记住我",
                                "value": true,
                                "mode": "inline"
                            }, {
                                "type": "button",
                                "label": "忘记密码？",
                                "level": "link",
                                "size": "sm",
                                "actionType": "link",
                                "link": "/forgot-password"
                            }]
                        }, {
                            "type": "button",
                            "label": "登录",
                            "level": "primary",
                            "size": "lg",
                            "block": true,
                            "actionType": "submit",
                            "className": "m-t-lg"
                        }, {"type": "divider", "lineStyle": "dashed"}],
                        "mode": "horizontal",
                        "horizontal": {
                            "leftFixed": "sm"
                        },
                        "columnCount": 1
                    }
                }
            }
        };

        // 渲染 AMis 页面
        amisRequire('amis/embed').embed('#amis-root', schema, {}, amisEnv);
    };
</script>
</html>
