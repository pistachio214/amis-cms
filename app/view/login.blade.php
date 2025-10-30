<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>登录页面</title>
    <!-- 引入 AMis SDK 核心样式 -->
    <link rel="stylesheet" href="{{ cms_asset('sdk.css') }}"/>
    <!-- 引入 icon 样式 -->
    <link rel="stylesheet" href="{{ cms_asset('icon/iconfont.css') }}"/>
    <!-- 引入 辅助样式 -->
    <link rel="stylesheet" href="{{ cms_asset('helper.css') }}"/>
</head>
<body>
<div id="amis-root" style="height:100vh;"></div>
</body>
<script src='{{ cms_asset('sdk.js') }}'></script>
<script src='{{ cms_asset('rest.js') }}'></script>
<script>
    (function () {
        // 后端传入的 schema
        const schema = {!! $schema !!};

        // 渲染 AMis 页面
        amisRequire('amis/embed').embed('#amis-root', schema, {}, {});
    })();
</script>
</html>
