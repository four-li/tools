<?php
/**                                                             ";
 * date: 2019/7/21
 * author: four-li
 */

namespace FourLi\Tools\Sms;


abstract class SmsService
{
    # 短信模板键值对
    protected $templates = [];

    protected $currentTemplateId = '';

    /**
     * - i.e. 选择模板  传入id 或者模板title 如过传title需要对应
     * - e.g.
     *
     * @param $idOrTitle
     * @return $this
     */
    public function useTemplate($idOrTitle)
    {
        $ids = array_values($this->templates);

        if (in_array($idOrTitle, $ids)) {
            $this->currentTemplateId = $idOrTitle;
        } else {
            $this->currentTemplateId = $this->templates[$idOrTitle] ?? '';
        }

        return $this;
    }
}
