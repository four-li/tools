<?php
/**                                                             ";
 * date: 2019/8/6
 * author: four-li
 */

namespace FourLi\Tools\Sdk;

use Curl\Curl;

class Sdk
{
    private $appKey;

    private $appSecret;

    private $signMethod = 'md5';

    private $gatewayUrl;

    private $sdkVersion = 1.0;

    private $format = 'json';

    private $curl;

    public function __construct(string $gatewayUrl, string $appKey, string $appSecret)
    {
        $this->appKey     = $appKey;
        $this->appSecret  = $appSecret;
        $this->gatewayUrl = rtrim($gatewayUrl, "\/") . '/';
        $this->curl       = new Curl();
    }

    protected function generateSign(array $params): string
    {
        ksort($params);
        $stringToBeSigned = $this->appKey;
        foreach ($params as $k => $v) {
            if ((is_string($v) || is_numeric($v)) && "@" != substr($v, 0, 1)) {
                $stringToBeSigned .= "$k$v";
            }
        }
        unset($k, $v);
        $stringToBeSigned .= $this->appSecret;

        return strtoupper(md5($stringToBeSigned));
    }

    public function getRawResponse(ClientInterface $client)
    {
        if (!$this->appKey || !$this->appSecret) return $this->exception('秘钥参数缺失');

        try {
            $client->check();
        } catch (\Exception $e) {
            return $this->exception($e->getMessage());
        }

        //组装系统参数
        $sysParams["appKey"]     = $this->appKey;
        $sysParams["appSecret"]  = $this->appSecret;
        $sysParams["v"]          = $this->sdkVersion;
        $sysParams["format"]     = $this->format;
        $sysParams["signMethod"] = $this->signMethod;
        $sysParams["method"]     = $client->getMethod();
        $sysParams["route"]      = $client->getRoute();
        $sysParams["timestamp"]  = time();
        $sysParams["nonce"]      = 'yaya=3=fourli';

        $apiParams = $client->getApiParameters();

        $parameters = array_merge($sysParams, $apiParams);

        $sign = $this->generateSign($parameters);

        $this->curl->setHeader('sdk-token', $sign);

        $this->curl->setHeader('Content-Type', 'application/json; charset=utf-8');

//        print_r($this->gatewayUrl . $client->getRoute());die;

        $this->curl->{$client->getMethod()}($this->gatewayUrl . $client->getRoute(), $parameters);

        return $this->successHandler();
    }

    private function successHandler()
    {
        $resp = $this->curl->getRawResponse();

        if ($this->format === 'json') {
            $view = json_decode($resp, true);
        }

        return $view ?? [];
    }

    private function exception($msg)
    {
        return [
            'code'    => 500,
            'msg'     => $msg,
            'payload' => []
        ];
    }
}

