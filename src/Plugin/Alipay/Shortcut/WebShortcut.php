<?php
/**
 * @desc WebShortcut.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2021/10/11 11:42
 */

declare(strict_types=1);

namespace Tinywan\Template\Plugin\Alipay\Shortcut;


use Tinywan\Template\Contract\ShortcutInterface;
use Tinywan\Template\Plugin\Alipay\HtmlResponsePlugin;
use Tinywan\Template\Plugin\Alipay\Trade\PagePayPlugin;

class WebShortcut implements ShortcutInterface
{
    public function getPlugins(array $params): array
    {
        return [
            PagePayPlugin::class,
            HtmlResponsePlugin::class,
        ];
    }
}