<?php
/**                                                             ";
 * date: 2019/7/21
 * author: four-li
 */

namespace FourLi\Tools\Sms\RongLian;

use FourLi\Tools\Sms\SmsService;
use Qcloud\Sms\SmsSingleSender;

class Client extends SmsService
{
    # 主账号，登陆云通讯网站后，可在控制台首页看到开发者主账号ACCOUNT SID。
    protected $accountSid;
    protected $accountToken;
    # 创建的应用的id
    protected $appId;

    //# 荣联短信
    public function __construct($accountSid, $accountToken, $appId, $templates = [])
    {
        $this->appId        = $appId;
        $this->accountSid   = $accountSid;
        $this->accountToken = $accountToken;
        $this->templates    = $templates;
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
        $rest = new RongLianUtils('app.cloopen.com', '8883', '2013-12-26');
        $rest->setAccount($this->accountSid, $this->accountToken);
        $rest->setAppId($this->appId);

        // 发送模板短信

        try {
            $result = $rest->sendTemplateSMS($mobile, $templateParameters, $templateId ?: $this->currentTemplateId);

            return [
                'code'    => 0,
                'msg'     => 'success',
                'payload' => [],
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
