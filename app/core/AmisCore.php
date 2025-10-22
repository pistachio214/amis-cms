<?php

namespace plugin\cms\app\core;

use support\Response;

/**
 * Amis 页面核心处理类
 */
class AmisCore
{
    // logo
    private string $logo = '/favicon.ico';

    // 页面标题
    private string $pageTitle = 'Amis 管理系统';

    // 页面详情
    private string $description = 'Amis Description';

    private string $title = '企业管理系统';

    private array $header = [];

    private string $username = '----';

    // 管理员部分
    private array $userDropdown = [];

    // 菜单数据
    private array $menuNav = [];

    // 实体数据
    private array $body;

    private array $page;

    // 底部版权说明
    private array $footer = [];

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setMenuNav(array $menuNav): self
    {
        $nav = [
            [
                "label" => "仪表板",
                "icon" => "fa fa-dashboard",
                "to" => "/dashboard",
                "active" => true
            ],
            [
                "label" => "用户管理",
                "icon" => "fa fa-users",
                "children" => [
                    [
                        "label" => "Nav 2-1",
                        "to" => "/docs/api-2-1-1"
                    ],
                    [
                        "label" => "Nav 2-2",
                        "to" => "/docs/api-2-2"
                    ]
                ]
            ],
            [
                "label" => "订单管理",
                "icon" => "fa fa-shopping-cart",
                "to" => "/orders"
            ],
            [
                "label" => "产品管理",
                "icon" => "fa fa-cube",
                "to" => "/products"
            ],
            [
                "label" => "数据统计",
                "icon" => "fa fa-bar-chart",
                "to" => "/analytics"
            ],
            [
                "label" => "系统设置",
                "icon" => "fa fa-cog",
                "to" => "/settings"
            ]
        ];

        $this->menuNav = [
            'type' => 'container',
            'style' => [
                'width' => 'var(--sidebar-width)',
                'borderRight' => '1px solid #e6e6e6',
                'overflowY' => 'auto',
                'height' => '100%',
            ],
            'body' => [
                'type' => 'nav',
                'stacked' => true,
                'unfolded' => false,
                'expandPosition' => 'after',
                'links' => $nav
            ]
        ];

        return $this;
    }

    public function setFooter(string $footer = null): self
    {
        if (empty($footer)) {
            $footer = '© 2025 企业管理系统 版权所有 | 技术支持: xxx-xxx-xxxx';
        }

        $this->footer = [
            'type' => 'container',
            'style' => [
                'backgroundColor' => '#f0f2f5',
                'height' => '50px',
                'borderTop' => '1px solid #e6e6e6',
                'textAlign' => 'center',
                'color' => '#666',
                'fontSize' => '#14px',
            ],
            'body' => [
                'type' => 'tpl',
                'tpl' => "<div><p>{$footer}</p></div>"
            ]
        ];

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function setUserDropdown(array $userDropdown = []): self
    {
        $dropdown = [
            [
                'label' => '个人中心',
                'actionType' => 'link',
                'link' => '/profile'
            ],
            [
                'label' => '系统设置',
                'actionType' => 'link',
                'link' => '/settings'
            ],
            [
                'type' => '/divider'
            ],
            [
                'label' => '退出登录',
                'actionType' => 'ajax',
                'api' => '/api/logout',
                'confirmText' => '确定要退出登录吗？'
            ],

        ];

        if (!empty($dropdown)) {
            $dropdown = array_merge($userDropdown, [['type' => '/divider']], $dropdown);
        }

        $this->userDropdown = [
            'type' => 'flex',
            'className' => 'header-right',
            'items' => [
                [
                    'type' => 'dropdown-button',
                    'label' => $this->username,
                    'btnLevel' => 'link',
                    'btnClassName' => 'dropdown-wrapper',
                    'menuClassName' => 'white-bg',
                    'trigger' => 'hover',
                    'buttons' => $dropdown
                ]
            ]
        ];

        return $this;
    }

    private function setHeader(): self
    {
        $this->header = [
            [
                'type' => 'flex',
                'className' => 'header-left',
                'items' => [
                    [
                        'type' => 'tpl',
                        'tpl' => "<div style='display:flex;align-items:center;gap:12px;'><img src='{$this->logo}' style='height:32px;' /><span style='font-size:18px;font-weight:bold;'>{$this->title}</span></div>",
                    ]
                ]
            ],

            // 管理员下拉操作
            $this->userDropdown
        ];

        return $this;
    }

    private function setPage(): self
    {
        $this->page = [
            [
                "type" => "container",
                "style" => [
                    "backgroundColor" => "var(--header-bg)",
                    "color" => "var(--header-color)",
                    "padding" => "0 24px",
                    "height" => "64px",
                    "display" => "flex",
                    "flexDirection" => "row",
                    "alignItems" => "center",
                    "justifyContent" => "space-between",
                    "boxShadow" => "0 2px 8px rgba(0,0,0,0.1)"
                ],
                "className" => "header-wrapper",
                "body" => $this->header
            ],
            [
                "type" => "container",
                "style" => [
                    "flex" => 1,
                    "display" => "flex",
                    "flexDirection" => "row",
                    "overflow" => "hidden",
                    "height" => "calc(100vh - 114px)"
                ],
                "className" => "content-wrapper",
                "body" => [
                    $this->menuNav,
                    [
                        "type" => "container",
                        "style" => [
                            "flex" => 1,
                            "padding" => "0",
                            "overflowY" => "auto",
                            "backgroundColor" => "#ffffff",
                            "height" => "100%"
                        ],
                        "body" => [
                            "type" => "page",
                            "body" => [
                                "type" => "tpl",
                                "tpl" => "<div style='text-align:center;padding:50px;'><h2>欢迎使用企业管理系统</h2><p>请从左侧菜单选择功能模块</p></div>"
                            ]
                        ]
                    ]
                ]
            ],
            $this->footer
        ];

        return $this;
    }


    public function getCore(): array
    {
        return [
            "type" => "page",
            "cssVars" => [
                "--primary-color" => "#1890ff",
                "--header-bg" => "#001529",
                "--header-color" => "#fff",
                "--sidebar-bg" => "#f5f5f5",
                "--sidebar-width" => "220px"
            ],
            "className" => "full-screen-page",
            "style" => [
                "height" => "100vh",
                "display" => "flex",
                "flexDirection" => "column"
            ],
            "body" => $this->page
        ];
    }

    public function build(): Response
    {
        dump($this->setPage()->setUserDropdown()->getCore());
        return view('amis', [
            'title' => $this->pageTitle, 'description' => $this->description,
            'schema' => json_encode($this->setPage()->setHeader()->setUserDropdown()->getCore())
        ]);
    }

}