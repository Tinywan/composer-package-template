<?php
/**
 * @desc 支付宝查询订单
 * @author Tinywan(ShaoBo Wan)
 * @date 2021/10/11 11:31
 */

declare(strict_types=1);

namespace Tinywan\Template\Plugin\Alipay\Trade;


use Tinywan\Template\Plugin\Alipay\GeneralPlugin;

class QueryPlugin extends GeneralPlugin
{
    protected function getMethod(): string
    {
        return 'alipay.trade.query';
    }
}