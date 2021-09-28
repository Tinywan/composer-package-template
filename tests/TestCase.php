<?php

namespace Tinywan\Template\Tests;


use Tinywan\Template\App;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * init action
     */
    protected function setUp(): void
    {
        $config = [
            'alipay' => [
                'default' => [
                    'app_id' => 'yansongda',
                ],
            ],
        ];
        App::config($config);
    }
}