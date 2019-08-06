<?php

include_once __DIR__ . '/../../vendor/autoload.php';

#####【 请求客户端 】#####

$appKey    = 'appkey11';
$appSecret = 'appsecret22';
$host      = 'http://localhost';

$sdk = new \FourLi\Tools\Sdk\Sdk($host, $appKey, $appSecret);

# 自定义请求 必须继承ClientInterface
# 自定义请求方法和请求地址 请求参数
class TestRequst implements \FourLi\Tools\Sdk\ClientInterface
{
    /**
     * @var $id int
     */
    private $id;

    /**
     * @var $otherParam array
     */
    private $otherParam = [];

    /**
     * @param array $otherParam
     * @return TestRequst
     */
    public function setOtherParam(array $otherParam): TestRequst
    {
        $this->otherParam = $otherParam;
        return $this;
    }

    /**
     * @param mixed $id
     * @return TestRequst
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function check()
    {
        // TODO: Implement check() method.
        if (true) {

        } else {
            throw new \Exception('参数错误');
        }
        return true;
    }

    public function getApiParameters()
    {
        $propertys = get_class_vars(__CLASS__);

        $let = [];
        # 默认使用this类的所有属性为参数
        foreach ($propertys as $property => $defaultVal) {
            $let[$property] = $this->$property;
        }

        # 若有特殊 需要自定义

        return $let;
    }

    public function getMethod()
    {
        return 'post';
    }

    public function getRoute()
    {
        return 'debug/sdk';
    }

}

$req = new TestRequst();
$req->setId(123123)->setOtherParam(['其它参数' => '我是自定义的']);

$ret = $sdk->getRawResponse($req);

var_dump($ret);

