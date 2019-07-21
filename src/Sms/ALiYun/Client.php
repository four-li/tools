<?php
/**                                                             ";
 * date: 2019/7/21
 * author: four-li
 */

namespace FourLi\Tools\Sms\ALiYun;


use FourLi\Tools\Sms\SmsService;

class Client extends SmsService
{
    protected $keyId;
    protected $keySecret;
    # 短信签名
    protected $smsSign;

    public function __construct($keyId, $keySecret, $smsSign, $templates = [])
    {
        $this->keyId     = $keyId;
        $this->keySecret = $keySecret;
        $this->smsSign   = $smsSign;
        $this->templates = $templates;
    }

    public function singleSend(int $mobile, $templateParameters = [], $templateId = null)
    {

        $params = array();

        // *** 需用户填写部分 ***
        $security = true;

        // 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
        $accessKeyId     = $this->keyId;
        $accessKeySecret = $this->keySecret;

        //  必填: 短信接收号码
        $params["PhoneNumbers"] = $mobile;

        //  必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = $this->smsSign;

        //  必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = $templateId ?: $this->currentTemplateId;

        //  可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $params['TemplateParam'] = $templateParameters;

        //  可选: 设置发送短信流水号
        $params['OutId'] = "12345";

        //  可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
        $params['SmsUpExtendCode'] = "1234567";


        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if (!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new SignatureHelper();

        try {
            // 此处可能会抛出异常，注意catch
            $content = $helper->request(
                $accessKeyId,
                $accessKeySecret,
                "dysmsapi.aliyuncs.com",
                array_merge($params, array(
                    "RegionId" => "cn-hangzhou",
                    "Action"   => "SendSms",
                    "Version"  => "2017-05-25",
                )),
                $security
            );

            return [
                'code'    => 0,
                'msg'     => 'success',
                'payload' => $content,
            ];
        } catch (\Exception $e) {
            return [
                'code'   => '500',
                'msg'    => '发送失败',
                'subMsg' => $e->getMessage()
            ];
        }
    }
}
