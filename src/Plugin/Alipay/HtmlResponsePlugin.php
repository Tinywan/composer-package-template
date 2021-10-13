<?php
/**
 * @desc 跳转响应 Plugin
 * @author Tinywan(ShaoBo Wan)
 * @date 2021/10/11 11:12
 */

declare(strict_types=1);

namespace Tinywan\Template\Plugin\Alipay;


use GuzzleHttp\Psr7\Response;
use Tinywan\Template\Contract\PluginInterface;
use Tinywan\Template\Logger;
use Tinywan\Template\Rocket;
use Yansongda\Supports\Arr;
use Yansongda\Supports\Collection;

class HtmlResponsePlugin implements PluginInterface
{
    /**
     * @desc: 方法描述
     * @param Rocket $rocket
     * @param \Closure $next
     * @return Rocket
     * @author Tinywan(ShaoBo Wan)
     */
    public function assembly(Rocket $rocket, \Closure $next): Rocket
    {
        Logger::info('[alipay][HtmlResponsePlugin] 插件开始装载', ['rocket' => $rocket]);

        /* @var Rocket $rocket */
        $rocket = $next($rocket);

        $radar = $rocket->getRadar();
        $response = 'GET' === $radar->getMethod() ?
            $this->buildRedirect($radar->getUri()->__toString(), $rocket->getPayload()) :
            $this->buildHtml($radar->getUri()->__toString(), $rocket->getPayload());

        $rocket->setDestination($response);

        Logger::info('[alipay][HtmlResponsePlugin] 插件装载完毕', ['rocket' => $rocket]);

        return $rocket;
    }

    /**
     * @desc: 方法描述
     * @param string $endpoint
     * @param Collection $payload
     * @return Response
     * @author Tinywan(ShaoBo Wan)
     */
    protected function buildRedirect(string $endpoint, Collection $payload): Response
    {
        $url = $endpoint.'?'.Arr::query($payload->all());

        $content = sprintf('<!DOCTYPE html>
                    <html lang="en">
                        <head>
                            <meta charset="UTF-8" />
                            <meta http-equiv="refresh" content="0;url=\'%1$s\'" />
                    
                            <title>Redirecting to %1$s</title>
                        </head>
                        <body>
                            Redirecting to %1$s.
                        </body>
                    </html>', htmlspecialchars($url, ENT_QUOTES)
        );

        return new Response(302, ['Location' => $url], $content);
    }

    /**
     * @desc: 方法描述
     * @param string $endpoint
     * @param Collection $payload
     * @return Response
     * @author Tinywan(ShaoBo Wan)
     */
    protected function buildHtml(string $endpoint, Collection $payload): Response
    {
        $sHtml = "<form id='alipay_submit' name='alipay_submit' action='".$endpoint."' method='POST'>";
        foreach ($payload->all() as $key => $val) {
            $val = str_replace("'", '&apos;', $val);
            $sHtml .= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }
        $sHtml .= "<input type='submit' value='ok' style='display:none;'></form>";
        $sHtml .= "<script>document.forms['alipay_submit'].submit();</script>";

        return new Response(200, [], $sHtml);
    }
}