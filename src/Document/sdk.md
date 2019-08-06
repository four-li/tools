使用自定义sdk来请求数据
---

## 签名解释

A程序使用sdk请求B程序 所有请求将在请求headers携带sdk-token签名 B程序收到请求验证是否合法
> sdk-token签名生成规则
1. 将所有请求的应用参数进行自然正序排序
2. 将非空值的数字和字符串参数进行key+value的拼接得到字符串$s1
3. 将appkey拼接在$s1的左边， 将appSecret拼接在$s1的右边得到$s2
4. 将$s2进行md5，再进行大写

## 使用

参阅 [demo](/src/Example/sdk.php) 
 
## 服务器端

请求安全组件事件或控制器中 检查token是否正确 及appkey和appsecret是否正确 

```php
/**
 * @Rest\Route("/debug/sdk")
 */
public function sdkTest(Request $request)
{
    $ret = $this->tokenAuth() ? 'token正确' : 'token错误';

    return new JsonResponse(['auth' => $ret]);
}

private function tokenAuth()
{
    $token = $this->_request->headers->get('sdk-token');

    # 所有get post参数
    $post       = json_decode($this->_request->getContent(), true);
    $parameters = array_merge($this->_request->query->all(), is_array($post) ? $post : []);

    $ret = $this->signChecker($token, $parameters);

    if ($ret) {
        // TODO 签名正确的情况下 检查appkey 和 appsecret是否正确
        $appKey    = $this->_request->get('appKey');
        $appSecret = $this->_request->get('appSecret');
    }

    return $ret;
}

private function signChecker($token, $params)
{
    ksort($params);

    $stringToBeSigned = $params['appKey'];
    foreach ($params as $k => $v) {
        if ((is_string($v) || is_numeric($v)) && "@" != substr($v, 0, 1)) {
            $stringToBeSigned .= "$k$v";
        }
    }
    unset($k, $v);
    $stringToBeSigned .= $params['appSecret'];

    $sign = strtoupper(md5($stringToBeSigned));

    if ($sign != $token) {
//            throw new \RuntimeException("非法请求. token无效");
        return false;
    }
    return true;
}
```
