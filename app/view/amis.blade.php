<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Amis 管理系统' }}</title>
    <!-- 引入 AMis SDK 核心样式 -->
    <link rel="stylesheet" href="{{ cms_asset('cxd.css') }}"/>
    <!-- 引入 辅助样式 -->
    <link rel="stylesheet" href="{{ cms_asset('helper.css') }}"/>
    <!-- 引入 icon 样式 -->
    <link rel="stylesheet" href="{{ cms_asset('icon/iconfont.css') }}"/>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .debug-info {
            position: fixed;
            top: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-size: 12px;
            z-index: 10000;
        }
    </style>
</head>
<body>
<div id="debugInfo" class="debug-info">Loading...</div>
<div id="amis-root" class="app-container" style="height:100vh;"></div>
</body>
<script src='{{ cms_asset('sdk.js') }}'></script>
<script src='{{ cms_asset('rest.js') }}'></script>
<script>
    window.onload = function () {
        const amis = amisRequire('amis/embed');

        // 先测试 API 数据
        fetch('/site.json')
            .then(response => response.json())
            .then(data => {
                document.getElementById('debugInfo').innerHTML =
                    `API loaded: ${data.data.pages.length} pages<br>
                     First page: ${data.data.pages[0].label}`;
                console.log('Site data:', data);
            })
            .catch(error => {
                document.getElementById('debugInfo').innerHTML = 'API load failed';
                console.error('API error:', error);
            });

        const amisJSON = {
            type: 'app',
            brandName: 'Admin',
            logo: '/favicon.ico',
            header: {
                type: 'tpl',
                inline: false,
                className: 'w-full',
                tpl: '<div class="flex justify-between"><div>顶部区域左侧</div><div>顶部区域右侧</div></div>'
            },
            footer: '<div class="p-2 text-center bg-light">© 2024 公司名称 版权所有</div>',
            asideFixed: true,
            asideSticky: true,
            collapsed: true,  // 侧边栏默认收起
            persistState: true,        // 持久化状态
            persistData: "localStorage", // 使用 localStorage 持久化
            saveOrder: true,           // 保存顺序
            api: '/app/cms/site.json'
        };

        amis.embed('#amis-root', amisJSON);
    }
</script>
</html>
