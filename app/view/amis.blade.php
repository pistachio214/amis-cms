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
<div id="debugInfo" class="debug-info">Loading...</div>
<div id="amis-root" class="app-container" style="height:100vh;"></div>
</body>
<script src='{{ cms_asset('sdk.js') }}'></script>
<script src='{{ cms_asset('rest.js') }}'></script>
<script>
    window.onload = function () {
        const amis = amisRequire('amis/embed');

        // 先测试 API 数据
        fetch('/app/cms/site.json')
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

        // const amisJSON = {
        //     type: 'app',
        //     brandName: 'Admin',
        //     logo: '/favicon.ico',
        //     header: {
        //         type: 'tpl',
        //         inline: false,
        //         className: 'w-full',
        //         tpl: '<div class="flex justify-between"><div>顶部区域左侧</div><div>顶部区域右侧</div></div>'
        //     },
        //     footer: '<div class="p-2 text-center bg-light">© 2024 公司名称 版权所有</div>',
        //     // asideFixed: true,
        //     // asideSticky: true,
        //     // collapsed: true,  // 侧边栏默认收起
        //     // persistState: true,        // 持久化状态
        //     // persistData: "localStorage", // 使用 localStorage 持久化
        //     // saveOrder: true,           // 保存顺序
        //     saveFoldable: true,  // 允许保存折叠状态
        //     folded: true,        // 初始折叠状态
        //     sidebar: {
        //         defaultCollapsed: true,  // 设置侧边栏默认折叠
        //         collapsed: true,
        //     },
        //     layout: {
        //         asideCollapsed: true
        //     },
        //     menu: {
        //         type: 'menu',
        //         children: [
        //             {
        //                 label: "一级菜单",
        //                 key: "topMenu",
        //                 isOpened: false, // 强制默认收起
        //                 actionType: "expand", // 关键：点击时触发展开而非跳转
        //                 onEvent: {
        //                     click: {
        //                         actions: [
        //                             {
        //                                 actionType: "toggle", // 切换展开/收起状态
        //                                 componentId: "topMenu",
        //                                 args: {
        //                                     isOpened: true
        //                                 } // 点击时展开
        //                             }
        //                         ]
        //                     }
        //                 },
        //                 children: [
        //                     {label: "二级菜单1", key: "subMenu1"},
        //                     {label: "二级菜单2", key: "subMenu2"}
        //                 ]
        //             }
        //         ]
        //     },
        //     body: {
        //         label: '111111',
        //         body: '222222'
        //     }
        // };

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
                                backgroundColor: "var(--sidebar-bg)",
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
                                                active: true
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
                        // padding: "16px",
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

        amis.embed('#amis-root', amisJSON);
    }
</script>
</html>
