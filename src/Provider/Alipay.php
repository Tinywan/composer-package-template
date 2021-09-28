<?php

declare(strict_types=1);

namespace Tinywan\Template\Provider;

use Tinywan\Template\Event;
use Yansongda\Supports\Str;

class Alipay extends AbstractProvider
{
    /**
     * @param string $shortcut
     * @param array $params
     * @return mixed
     */
//    public function __call(string $shortcut, array $params)
//    {
//        $plugin = '\\Yansongda\\Pay\\Plugin\\Alipay\\Shortcut\\'.
//            Str::studly($shortcut).'Shortcut';
//
//        return $this->call($plugin, ...$params);
//    }

    public function find($order)
    {
        $order = is_array($order) ? $order : ['out_trade_no' => $order];

        Event::dispatch(new Event\MethodCalled('wechat', __METHOD__, $order, null));

//        return $this->__call('query', [$order]);
    }
}