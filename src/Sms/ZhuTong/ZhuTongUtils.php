<?php
/**                                                             ";
 * date: 2019/7/22
 * author: four-li
 */

namespace FourLi\Tools\Sms\ZhuTong;


class ZhuTongUtils
{
    /**
     * 发送API
     * demo仅供参考，demo最低运行环境PHP5.3
     * 请确认开启PHP CURL 扩展
     */
    public  $data;    //发送数据
    public  $timeout = 30; //超时
    private $apiUrl;    //发送地址
    private $username;    //用户名
    private $password;    //密码

    function __construct($url, $username, $password)
    {
        $this->apiUrl   = $url;
        $this->username = $username;
        $this->password = $password;
    }

    private function httpGet()
    {
        $url  = $this->apiUrl . '?' . http_build_query($this->data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'Error GET ' . curl_error($curl);
        }
        curl_close($curl);
        return $res;
    }

    private function httpPost()
    { // 模拟提交数据函数
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $this->apiUrl); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, @$_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_POST, true); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($this->data)); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, false); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // 获取的信息以文件流的形式返回
        $result = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Error POST' . curl_error($curl);
        }
        curl_close($curl); // 关键CURL会话
        return $result; // 返回数据
    }

    /**
     * @param $type          |提交类型 POST/GET
     * @param $isTranscoding |是否需要转 $isTranscoding 是否需要转utf-8 默认 false
     * @return mixed
     */
    public function sendSMS($type, $isTranscoding = false)
    {
        $this->data['content']  = $isTranscoding === true ? mb_convert_encoding($this->data['content'], "UTF-8") : $this->data['content'];
        $this->data['username'] = $this->username;
        date_default_timezone_set("PRC");
        $this->data['tkey']     = date('YmdHis', time());
        $this->data['password'] = md5(md5($this->password) . $this->data['tkey']);
        return $type == "POST" ? $this->httpPost() : $this->httpGet();
    }
}
