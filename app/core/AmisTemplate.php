<?php

namespace plugin\cms\app\core;

use plugin\cms\app\exception\AmisException;

/**
 * 模版处理
 */
class AmisTemplate
{
    private string $templatePath;

    private array $replacements;

    public function __construct(array $replacements = [])
    {
        $this->templatePath = dirname(__DIR__) . '/view/schema' . '/layout.template';
        $this->replacements = $replacements;
    }

    /**
     * @throws AmisException
     */
    public function markers(): string
    {
        $content = $this->readEntireFile();

        // 将替换后的字符串解析为PHP数组
        $data = json_decode($content, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new AmisException("替换后的JSON解析错误: " . json_last_error_msg());
        }

        // 中文不转义
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 读取整个文件内容
     * @throws AmisException
     */
    private function readEntireFile(): string
    {
        if (!file_exists($this->templatePath)) {
            throw new AmisException("文件不存在: {$this->templatePath}");
        }

        if (!is_readable($this->templatePath)) {
            throw new AmisException("模版文件不可读: {$this->templatePath}");
        }

        $content = file_get_contents($this->templatePath);

        if ($content === false) {
            throw new AmisException("读取模版文件失败: {$this->templatePath}");
        }

        // 执行替换
        foreach ($this->replacements as $marker => $value) {
            $placeholder = '{{' . $marker . '}}';
            $replacement = $this->safeFormatValue($value);
            $content = str_replace($placeholder, $replacement, $content);
        }

        return $content;
    }

    /**
     * 安全地格式化值
     */
    private function safeFormatValue($value): false|string
    {
        return match (gettype($value)) {
            'array', 'object' => json_encode($value, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
            'boolean' => $value ? 'true' : 'false',
            'NULL' => 'null',
            'string' => $value,
            'integer', 'double' => (string)$value,
            default => (string)$value,
        };
    }

}