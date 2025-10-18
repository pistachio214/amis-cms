<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>AMis SDK Demo</title>
    <!-- 引入 AMis SDK 核心样式 -->
    <link rel="stylesheet" href="{{ cms_asset('sdk.css') }}"/>
    <!-- 引入 icon 样式 -->
    <link rel="stylesheet" href="{{ cms_asset('icon/iconfont.css') }}"/>
    <!-- 引入 辅助样式 -->
    <link rel="stylesheet" href="{{ cms_asset('helper.css') }}"/>
    <style>
        html,
        body,
        .app-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
<div id="amis-root" style="height:100vh;"></div>
</body>
<script src='{{ cms_asset('sdk.js') }}'></script>
<script src='{{ cms_asset('rest.js') }}'></script>
<script>

    const app = {
        type: 'app',
        brandName: 'Admin',
        logo: '/favicon.ico',
        header: {
            type: 'tpl',
            inline: false,
            className: 'w-full',
            tpl: '<div class="flex justify-between"><div>顶部区域左侧</div><div>顶部区域右侧</div></div>'
        },
        footer: '<div class="p-2 text-center bg-light">底部区域</div>',
        // asideBefore: '<div class="p-2 text-center">菜单前面区域</div>',
        // asideAfter: '<div class="p-2 text-center">菜单后面区域</div>',
        api: '/site.json'
    };


    // 后端传入的 schema
    {{--const schema = {!! $schema !!};--}}
    const schema = {};

    // 渲染 AMis 页面
    amisRequire('amis/embed').embed('#amis-root', app, {}, {
        // theme: 'sdk'
    });
</script>
</html>
