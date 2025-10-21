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

        /* 兼容所有主题的全屏样式 */
        .full-screen-page [class*="Page-body"] {
            padding: 0 !important;
            margin: 0 !important;
        }

        .full-screen-page [class*="Page-main"] {
            margin: 0 !important;
            padding: 0 !important;
        }

        .full-screen-page [class*="Page-root"] {
            margin: 0 !important;
            padding: 0 !important;
        }

        .header-wrapper [class*="Container-body"] {
            display: flex;
            flex-direction: row;
            width: 100%;
            justify-content: space-between;
        }

        .content-wrapper > [class*="Container-body"]:first-child {
            width: 100%;
            display: flex;
            flex-direction: row;
        }
    </style>
</head>
<body>
<div id="amis-root" class="app-container" style="height:100vh;"></div>
</body>
<script src='{{ cms_asset('sdk.js') }}'></script>
<script src='{{ cms_asset('rest.js') }}'></script>
<script>
    window.onload = function () {
        let amisJSON = {
            type: "page",
            cssVars: {
                "--primary-color": "#1890ff",
                "--header-bg": "#001529",
                "--header-color": "#fff",
                "--sidebar-bg": "#f5f5f5",
                "--sidebar-width": "220px"
            },
            className: 'full-screen-page',
            style: {
                height: "100vh",
                display: "flex",
                flexDirection: "column",
            },
            body: [
                {
                    type: "container",
                    style: {
                        backgroundColor: "var(--header-bg)",
                        color: "var(--header-color)",
                        padding: "0 24px",
                        height: "64px",
                        display: "flex",
                        flexDirection: 'row',
                        alignItems: "center",
                        justifyContent: "space-between",
                        boxShadow: "0 2px 8px rgba(0,0,0,0.1)",
                    },
                    className: 'header-wrapper',
                    body: [
                        {
                            type: "flex",
                            className: "header-left",
                            items: [
                                {
                                    type: "tpl",
                                    tpl: "<div style=\"display:flex;align-items:center;gap:12px;\"><img src='/favicon.ico' style=\"height:32px;\" /><span style=\"font-size:18px;font-weight:bold;\">企业管理系统</span></div>"
                                }
                            ]
                        },
                        {
                            type: "flex",
                            className: "header-right",
                            items: [
                                {
                                    type: "dropdown-button",
                                    label: "张三 (管理员)",
                                    btnLevel: "link",
                                    menuClassName: "white-bg",
                                    trigger: "hover",
                                    buttons: [
                                        {
                                            label: "个人中心",
                                            actionType: "link",
                                            link: "/profile"
                                        },
                                        {
                                            label: "系统设置",
                                            actionType: "link",
                                            link: "/settings"
                                        },
                                        {
                                            type: "divider"
                                        },
                                        {
                                            label: "退出登录",
                                            actionType: "ajax",
                                            api: "/api/logout",
                                            confirmText: "确定要退出登录吗？"
                                        }
                                    ]
                                }
                            ]
                        }
                    ]
                },
                {
                    type: "container",
                    style: {
                        flex: 1,
                        display: "flex",
                        flexDirection: 'row',
                        overflow: "hidden",
                        height: 'calc(100vh - 114px)'
                    },
                    className: 'content-wrapper',
                    body: [
                        {
                            type: "container",
                            style: {
                                width: "var(--sidebar-width)",
                                // backgroundColor: "var(--sidebar-bg)",
                                borderRight: "1px solid #e6e6e6",
                                overflowY: "auto",
                                height: '100%',
                            },
                            body: {
                                type: "nav",
                                stacked: true,
                                unfolded: false,
                                expandPosition: 'after',
                                links: [
                                    {
                                        label: "仪表板",
                                        icon: "fa fa-dashboard",
                                        to: "/dashboard",
                                        active: true
                                    },
                                    {
                                        label: "用户管理",
                                        icon: "fa fa-users",
                                        children: [
                                            {
                                                label: "Nav 2-1",
                                                to: "/docs/api-2-1-1",

                                            },
                                            {
                                                label: "Nav 2-2",
                                                to: "/docs/api-2-2",
                                            }
                                        ]
                                    },
                                    {
                                        label: "订单管理",
                                        icon: "fa fa-shopping-cart",
                                        to: "/orders"
                                    },
                                    {
                                        label: "产品管理",
                                        icon: "fa fa-cube",
                                        to: "/products"
                                    },
                                    {
                                        label: "数据统计",
                                        icon: "fa fa-bar-chart",
                                        to: "/analytics"
                                    },
                                    {
                                        label: "系统设置",
                                        icon: "fa fa-cog",
                                        to: "/settings"
                                    }
                                ]
                            }
                        },
                        {
                            type: "container",
                            style: {
                                flex: 1,
                                padding: "0",
                                overflowY: "auto",
                                backgroundColor: "#fafafa",
                                height: '100%',
                            },
                            body: {
                                type: "page",
                                body: {
                                    type: "tpl",
                                    tpl: "<div style=\"text-align:center;padding:50px;\"><h2>欢迎使用企业管理系统</h2><p>请从左侧菜单选择功能模块</p></div>"
                                }
                            }
                        }
                    ]
                },
                {
                    type: "container",
                    style: {
                        backgroundColor: "#f0f2f5",
                        height: '50px',
                        borderTop: "1px solid #e6e6e6",
                        textAlign: "center",
                        color: "#666",
                        fontSize: "14px"
                    },
                    body: [
                        {
                            type: "tpl",
                            tpl: "<div><p>© 2023 企业管理系统 版权所有 | 技术支持: 400-123-4567</p></div>"
                        }
                    ]
                }
            ]
        }

        const amis = amisRequire('amis/embed');
        amis.embed('#amis-root', amisJSON);
    }
</script>
</html>
