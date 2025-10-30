<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>登录页面</title>

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
        // 后端传入的 schema
        const schema = {!! $schema !!};

        // 渲染 AMis 页面
        amisRequire('amis/embed').embed('#amis-root', schema, {}, {});
    };
</script>
</html>
