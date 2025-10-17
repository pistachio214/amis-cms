<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>登录页面</title>
    <!-- 引入 AMis SDK -->
    <link rel="stylesheet" href="/assets/amis/sdk.css"/>
        <link rel="stylesheet" href="/assets/amis/sdk.css"/>
    <link rel="stylesheet" href="/assets/amis/helper.css"/>
    <script src='/assets/amis/sdk.js'></script>
    <script src='/assets/amis/rest.js'></script>
</head>
<body>
<div id="amis-root" style="height:100vh;"></div>

<script>
    // 后端传入的 schema
    const schema = {!! $schema !!};

    // 渲染 AMis 页面
    amisRequire('amis/embed').embed('#amis-root', schema, {}, {
        // theme: 'sdk'
    });
</script>
</body>
</html>
