<?php
/**                                                             ";
 * date: 2019/7/21
 * author: four-li
 */

namespace FourLi\Tools\Sms\ZhuTong;

use FourLi\Tools\Sms\SmsService;
use Qcloud\Sms\SmsSingleSender;

class Client extends SmsService
{
    # 主账号，登陆云通讯网站后，可在控制台首页看到开发者主账号ACCOUNT SID。
    protected $username;
    protected $password;

    //# 荣联短信
    public function __construct($username, $password, $templates = [])
    {
        $this->username  = $username;
        $this->password  = $password;
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
        $url      = "http://www.api.zthysms.com/sendSms.do";//提交地址
        $username = $this->username; //用户名
        $password = $this->password; //原密码
        $sendAPI  = new ZhuTongUtils($url, $username, $password);

        $tempId = $templateId ?: $this->currentTemplateId;
        $data   = array(
            'content' => $templateParameters ? $tempId . $templateParameters[0] : '',//短信内容
            'mobile'  => $mobile,//手机号码
            // 'xh'		=> ''//小号
        );

// 70个字符为一条计费，最多支持500个字符，实际支持的最大字符根据通道方限制为准(一般是300—500个字符不等)。超过70个字按67个字符一条计费，例如，给一个号码提交了一条137个字符的短信137=67*2+3超过了2条计费一个号码就会按3条计费。【70=1条；71=2条；134=2条；135=3条】
// 注意事项：如果在后台设置固定签名，计费字符=短信内容字符+固定签名字符
        $sendAPI->data = $data;//初始化数据包
        $ret           = $sendAPI->sendSMS('POST');
        return [
            'code'    => 0,
            'msg'     => 'success',
            'payload' => [
                $ret
            ],
        ];
    }

}
