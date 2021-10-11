<?php
/**
 * @desc OriginResponseParserTest.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2021/10/11 10:40
 */


namespace Tinywan\Template\Tests\Parser;


use Tinywan\Template\Exception\InvalidResponseException;
use Tinywan\Template\Parser\OriginResponseParser;
use Tinywan\Template\Tests\TestCase;

class OriginResponseParserTest extends TestCase
{
    public function testResponseNull()
    {
        self::expectException(InvalidResponseException::class);
        self::expectExceptionCode(InvalidResponseException::INVALID_RESPONSE_CODE);

        $parser = new OriginResponseParser();
        $parser->parse(null);
    }
}