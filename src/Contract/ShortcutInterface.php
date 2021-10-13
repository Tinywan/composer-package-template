<?php
/**
 * @desc ShortcutInterface.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2021/10/11 11:41
 */


namespace Tinywan\Template\Contract;


interface ShortcutInterface
{
    /**
     * @desc: 方法描述
     * @param array $params
     * @return PluginInterface[]|string[]
     */
    public function getPlugins(array $params): array;
}