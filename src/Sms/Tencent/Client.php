<?php
/**                                                             ";
 * date: 2019/7/21
 * author: four-li
 */

namespace FourLi\Tools\Sms\Tencent;

use FourLi\Tools\Sms\SmsService;
use Qcloud\Sms\SmsSingleSender;

class Client extends SmsService
{
    # 短信运营商配置
    protected $appId;
    protected $appKey;
    # 短信签名
    protected $smsSign;

    public function __construct($appId, $appKey, $smsSign, $templates = [])
    {
        $this->appId     = $appId;
        $this->appKey    = $appKey;
        $this->smsSign   = $smsSign;
        $this->templates = $templates;
    }

    /**
     * - i.e. 单条短信发送
     * - e.g.
     *
     * @param int    $mobile
     * @param array  $templateParameters - 选择模板id后 需要传入的id
     * @param string $templateId         - 如过第三个参数传入模板id 则忽略useTemplate方法 直接使用该参数id
     * @return array
     */
    public function singleSend(int $mobile, $templateParameters = [], $templateId = null)
    {
        try {
            $ssender = new SmsSingleSender($this->appId, $this->appKey);
            $result  = $ssender->sendWithParam("86", $mobile, $templateId ?: $this->currentTemplateId, $templateParameters, $this->smsSign, "", "");  // 签名参数未提供或者为空时，会使用默认签名发送短信
            $rsp     = json_decode($result, true);
            return [
                'code'    => 0,
                'msg'     => 'success',
                'payload' => $rsp,
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
