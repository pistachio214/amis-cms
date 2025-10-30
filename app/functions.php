<?php
/**
 * Here is your custom functions.
 */
use plugin\cms\app\exception\AmisException;

if (!function_exists('plugin_asset')) {
    function plugin_asset($path, $pluginName = 'cms'): string
    {
        return "/app/{$pluginName}/{$path}";
    }
}

if (!function_exists('cms_asset')) {
    function cms_asset($path, $pluginName = 'cms'): string
    {
        return "/app/{$pluginName}/assets/{$path}";
    }
}

if (!function_exists('read_amis_json')) {
    function read_amis_json(string $filePath): array
    {
        if (!file_exists($filePath)) {
            throw new AmisException("文件不存在: {$filePath}");
        }

        $content = file_get_contents($filePath);
        if ($content === false) {
            throw new AmisException("读取文件失败: {$filePath}");
        }

        $data = json_decode($content, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new AmisException("JSON 解析错误: " . json_last_error_msg());
        }

        return $data;
    }
}
