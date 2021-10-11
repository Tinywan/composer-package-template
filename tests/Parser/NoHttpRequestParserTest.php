<?php
/**
 * @desc NoHttpRequestParserTest.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2021/10/11 10:45
 */


namespace Tinywan\Template\Tests\Parser;


use GuzzleHttp\Psr7\Response;
use Tinywan\Template\Parser\NoHttpRequestParser;
use Tinywan\Template\Tests\TestCase;

class NoHttpRequestParserTest extends TestCase
{
    public function testNormal()
    {
        $response = new Response(200, [], '{"name": "yansongda"}');

        $parser = new NoHttpRequestParser();
        $result = $parser->parse($response);

        self::assertSame($response, $result);
    }

    public function testNull()
    {
        $parser = new NoHttpRequestParser();
        $result = $parser->parse(null);

        self::assertNull($result);
    }
}