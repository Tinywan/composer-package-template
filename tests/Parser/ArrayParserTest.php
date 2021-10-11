<?php
/**
 * @desc ArrayParserTest.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2021/10/11 10:35
 */


namespace Tinywan\Template\Tests\Parser;


use GuzzleHttp\Psr7\Response;
use Tinywan\Template\Exception\InvalidResponseException;
use Tinywan\Template\Parser\ArrayParser;
use Tinywan\Template\Tests\TestCase;

class ArrayParserTest extends TestCase
{
    public function testResponseNull()
    {
        self::expectException(InvalidResponseException::class);
        self::expectExceptionCode(InvalidResponseException::RESPONSE_NONE);

        $parser = new ArrayParser();
        $parser->parse(null);
    }

    public function testWrongFormat()
    {
        self::expectException(InvalidResponseException::class);
        self::expectExceptionCode(InvalidResponseException::UNPACK_RESPONSE_ERROR);

        $response = new Response(200, [], '{"name": "Tinywan"}a');

        $parser = new ArrayParser();
        $result = $parser->parse($response);
        self::assertNotEquals(['name' => 'yansongda'], $result);
    }

    public function testNormal()
    {
        $response = new Response(200, [], '{"name": "Tinywan"}');

        $parser = new ArrayParser();
        $result = $parser->parse($response);

        self::assertEquals(['name' => 'Tinywan'], $result);
    }
}