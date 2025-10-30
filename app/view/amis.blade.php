<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Amis 管理系统' }}</title>

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
<div id="amis-root" class="app-container"></div>
</body>
<script src='{{ cms_asset('amis/sdk.js') }}'></script>
<script src='{{ cms_asset('amis/rest.js') }}'></script>
<script>
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

    window.onload = function () {
        const schema = {!! $schema !!};
        amisRequire('amis/embed').embed('#amis-root', schema, {}, amisEnv);
    }
</script>
</html>
