<?php
/**
 * @desc CollectionParserTest.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2021/10/11 10:43
 */


namespace Tinywan\Template\Tests\Parser;


use GuzzleHttp\Psr7\Response;
use Tinywan\Template\App;
use Tinywan\Template\Parser\CollectionParser;
use Tinywan\Template\Tests\TestCase;

class CollectionParserTest extends TestCase
{
    public function testNormal()
    {
        App::config([]);

        $response = new Response(200, [], '{"name": "Tinywan"}');

        $parser = new CollectionParser();
        $result = $parser->parse($response);

        self::assertEquals(['name' => 'Tinywan'], $result->all());
    }
}