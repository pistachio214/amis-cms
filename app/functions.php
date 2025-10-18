<?php
/**
 * Here is your custom functions.
 */

if (!function_exists('plugin_asset')) {
    function plugin_asset($path, $pluginName = 'cms'): string
    {
        return "/app/{$pluginName}/{$path}";
    }
}

if (!function_exists('cms_asset')) {
    function cms_asset($path, $pluginName = 'cms'): string
    {
        return "/app/{$pluginName}/assets/amis/{$path}";
    }
}

