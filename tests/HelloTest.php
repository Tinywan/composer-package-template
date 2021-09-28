<?php

namespace Tinywan\Template\Tests;


use Tinywan\Template\Hello;

class HelloTest extends TestCase
{
    public function testConfig()
    {
        $obj = new Hello();
        self::assertIsBool($obj->isBoole());
        self::assertEmpty($obj->isEmpty());
        self::assertSame('isYear',$obj->isYearString());
        self::assertIsString($obj->isStrictString('isStrictString'));
        self::assertIsInt($obj->isMultipleInt(1,2,3,4));
        self::assertIsArray($obj->isArray());
        self::assertIsArray($obj->isArrayMerge(['one'],['second'],['third']));
    }
}