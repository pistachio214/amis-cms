<?php

namespace plugin\cms\app\core;

use plugin\cms\app\exception\AmisException;
use support\Response;

/**
 * 扩展基础Amis基础使用
 * Trait AmisTrait
 * @package plugin\cms\app\core
 *
 * @author pengsy <songyang410@outlook.com>
 * @date   2025-10-29 10:23:18
 */
trait AmisTrait
{
    private string $title;

    private string $description = '';

    private array $replacements = [];

    private string $logo = '/favicon.ico';

    private string $system = '企业管理系统';

    private array $userDropdown = [];

    private string $footer = '© 2025 企业管理系统 版权所有 | 技术支持: 111-222-3333';

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * TODO 输出页面
     * @param string $view
     * @param array $data 附加参数
     * @param string $target
     * @return Response
     * @author pengsy <songyang410@outlook.com>
     * @date   2025-10-29 10:37:31
     */
    public function view(string $view, array $data = [], string $target = 'amis'): Response
    {
        $this->replacements($view);

        $this->extension();

        $template = new AmisTemplate($this->replacements);
        $schema = $template->markers();

        return view($target,
            array_merge_recursive([
                'schema' => $schema, 'title' => $this->title, 'description' => $this->description
            ], $data));
    }

    /**
     * 构建模版需要的参数
     * @throws AmisException
     */
    private function replacements(string $view): void
    {
        $viewPath = self::getViewPath() . '/' . $view . '.json';
        $bodySchema = read_amis_json($viewPath);

        $this->replacements = [
            'logo' => $this->logo,
            'system' => $this->system,
            'username' => $this->getUsername() ?: 'Amis管理员',
            'userDropdown' => $this->getUserDropdown(),
            'menuList' => $this->getMenuList() ?: [],
            'body' => $bodySchema ?: [],
            'footer' => $this->footer
        ];
    }

    // 扩展方法,可以自定义部分投影到模版文件
    private function extension(): void
    {
        // something code.....
        // 重写下拉button
//        $this->userDropdown = [];
//        $this->replacements['userDropdown'] = $this->getUserDropdown();
    }

    private function getUserDropdown(): array
    {
        $defaultUserDropdown = [
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
                'type' => 'divider'
            ],
            [
                'label' => '退出登录',
                'actionType' => 'ajax',
                'api' => '/api/logout',
                'confirmText' => '确定要退出登录吗？'
            ],
        ];

        if ($this->userDropdown) {
            // 当前为一维数组组成的下拉菜单,需要包装成二维数组进行合并
            if (count($this->userDropdown) == count($this->userDropdown, 1)) {
                $this->userDropdown = [$this->userDropdown];
            }

            $this->userDropdown = array_merge($this->userDropdown, [['type' => 'divider']], $defaultUserDropdown);
        } else {
            $this->userDropdown = $defaultUserDropdown;
        }

        return $this->userDropdown;
    }

    private function getUsername(): string
    {
        return "张老三(管理员)";
    }

    // TODO 模拟获取人员菜单
    private function getMenuList(): array
    {
        return [
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
    }

    /**
     * 获取插件 view 路径
     */
    private static function getViewPath(): string
    {
        return dirname(__DIR__) . '/view/schema';
    }
}