<?php

namespace Modules\Admin\Helpers;

class MenuHelper
{
    public static function getMainNavItems()
    {
        return [
            [
                'icon' => 'home',
                'name' => 'Dashboard',
                'path' => route('admin.dashboard'),
            ],
            [
                'icon' => 'notification',
                'name' => 'Notifications',
                'path' => '/',
            ],

        ];
    }

    public static function getContentManagement()
    {
        return [
            [
                'icon' => 'photo',
                'name' => 'Posts',
                'path' => route('admin.posts'),
            ],
            [
                'icon' => 'Tag',
                'name' => 'Tags',
                'path' => '/',
            ],
            [
                'icon' => 'category',
                'name' => 'Categories',
                'path' => '/',
            ],
            [
                'icon' => 'slides',
                'name' => 'Slides',
                'path' => '/',
            ],
            [
                'icon' => 'pages',
                'name' => 'Pages',
                'path' => '/',
            ],
            [
                'icon' => 'reports',
                'name' => 'Reports',
                'path' => '/',
            ],
        ];
    }

    public static function getUsersPrivileges()
    {
        return [
            [
                'icon' => 'members',
                'name' => 'Members',
                'path' => route('admin.members.page'),
            ],
            [
                'icon' => 'acl',
                'name' => 'ACL',
                'subItems' => [
                    ['name' => 'Users', 'path' => route('admin.acl.users.index'), 'pro' => false],
                    ['name' => 'Roles', 'path' => route('admin.acl.roles.index'), 'pro' => false],
                    ['name' => 'Permissions', 'path' => route('admin.acl.permissions.index'), 'pro' => false],
                ],
            ],
        ];
    }

    public static function getMonetization()
    {
        return [
            [
                'icon' => 'monetization',
                'name' => 'Monetization',
                'path' => '/',
            ],
        ];
    }

    public static function getScraping()
    {
        return [
            [
                'icon' => 'scrap',
                'name' => 'Scraping',
                'subItems' => [
                    ['name' => 'Web Scraping', 'path' => '/', 'pro' => false],
                    ['name' => 'Cron Job', 'path' => '/', 'pro' => false],
                ],
            ],
        ];
    }

    public static function getSystemSettings()
    {
        return [
            [
                'icon' => 'limit',
                'name' => 'Api Rate Limit',
                'path' => '/',
            ],
            [
                'icon' => 'media',
                'name' => 'Media Settings',
                'path' => '/',
            ],
            [
                'icon' => 'smtp',
                'name' => 'SMTP Settings',
                'path' => '/',
            ],
            [
                'icon' => 'backup',
                'name' => 'Backup Settings',
                'path' => '/',
            ],
            [
                'icon' => 'bell',
                'name' => 'Notification Settings',
                'path' => '/',
            ],
            [
                'icon' => 'optimization',
                'name' => 'Optimization',
                'subItems' => [
                    ['name' => 'Seo Settings', 'path' => '/', 'pro' => false],
                    ['name' => 'Image Optimization', 'path' => '/', 'pro' => false],
                    ['name' => 'Maintenance Settings', 'path' => '/', 'pro' => false],
                ],
            ],
        ];
    }

    public static function getPlatformSettings()
    {
        $items = [
            [
                'icon' => 'auth',
                'name' => 'Auth Security Rules',
                'path' => route('core.platform.auth-rules.index'),
                'permission' => 'twofactor.settings.update'
            ],
            [
                'icon' => 'post',
                'name' => 'Post Moderation',
                'path' => '/',
            ],
            [
                'icon' => 'analytics',
                'name' => 'Analytics',
                'path' => '/',
            ],
        ];

        if (module_enabled('Auditlog')) {
            $items[] = [
                'icon' => 'audit',
                'name' => 'Audit Logs',
                'path' => route('auditlog.index'),
            ];
        }

        return array_merge($items, [
            [
                'icon' => 'request',
                'name' => 'Request Logs',
                'path' => '/',
            ],
            [
                'icon' => 'system',
                'name' => 'System Information',
                'path' => '/',
            ],
        ]);
    }

    public static function getOthersItems()
    {
        $items = [];

        if (module_enabled('ModuleManagement')) {
            $items[] = [
                'icon' => 'authentication',
                'name' => 'Modules',
                'subItems' => [
                    ['name' => 'Installed', 'path' => route('admin.modules.index'), 'pro' => false],
                ],
            ];
        }

        return $items;
    }

    public static function getMenuGroups()
    {
        return [
            [
                'title' => 'Overview',
                'items' => self::getMainNavItems(),
            ],
            // [
            //     'title' => 'Content Management',
            //     'items' => self::getContentManagement(),
            // ],
            [
                'title' => 'Members and Access Control',
                'items' => self::getUsersPrivileges(),
            ],
            // [
            //     'title' => 'Monetization',
            //     'items' => self::getMonetization(),
            // ],
            // [
            //     'title' => 'Scraping and Automation',
            //     'items' => self::getScraping(),
            // ],
            [
                'title' => 'System Settings',
                'items' => self::getSystemSettings(),
            ],
            [
                'title' => 'Platform Settings',
                'items' => self::getPlatformSettings(),
            ],
            [
                'title' => 'Others',
                'items' => self::getOthersItems(),
            ],
        ];
    }

    public static function isActive($path)
    {
        return request()->is(ltrim($path, '/'));
    }

    public static function getIconSvg($iconName)
    {
        $outlineIcon = svg('o-'.strtolower($iconName));

        if ($outlineIcon !== '') {
            return $outlineIcon;
        }

    }
}
