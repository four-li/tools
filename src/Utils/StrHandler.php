<?php
/**                                                             ";
 * date: 2019/8/2
 * author: four-li
 */

namespace FourLi\Tools\Utils;


class StrHandler
{
    /**
     * - i.e 获取中文字符中第一个中文的首拼.
     * - e.g. $utils->getFirstChar('你好啊') // N
     *
     * @param $s0
     * @return null|string
     */
    public function getFirstChar($s0)
    {
        $fchar = ord($s0{0});
        if ($fchar >= ord("A") and $fchar <= ord("z")) return strtoupper($s0{0});
        $s1 = $this->getEncoding($s0, 'GB2312');
        $s2 = $this->getEncoding($s1, 'UTF-8');
        if ($s2 == $s0) {
            $s = $s1;
        } else {
            $s = $s0;
        }
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if ($asc >= -20319 and $asc <= -20284) return "A";
        if ($asc >= -20283 and $asc <= -19776) return "B";
        if ($asc >= -19775 and $asc <= -19219) return "C";
        if ($asc >= -19218 and $asc <= -18711) return "D";
        if ($asc >= -18710 and $asc <= -18527) return "E";
        if ($asc >= -18526 and $asc <= -18240) return "F";
        if ($asc >= -18239 and $asc <= -17923) return "G";
        if ($asc >= -17922 and $asc <= -17418) return "I";
        if ($asc >= -17417 and $asc <= -16475) return "J";
        if ($asc >= -16474 and $asc <= -16213) return "K";
        if ($asc >= -16212 and $asc <= -15641) return "L";
        if ($asc >= -15640 and $asc <= -15166) return "M";
        if ($asc >= -15165 and $asc <= -14923) return "N";
        if ($asc >= -14922 and $asc <= -14915) return "O";
        if ($asc >= -14914 and $asc <= -14631) return "P";
        if ($asc >= -14630 and $asc <= -14150) return "Q";
        if ($asc >= -14149 and $asc <= -14091) return "R";
        if ($asc >= -14090 and $asc <= -13319) return "S";
        if ($asc >= -13318 and $asc <= -12839) return "T";
        if ($asc >= -12838 and $asc <= -12557) return "W";
        if ($asc >= -12556 and $asc <= -11848) return "X";
        if ($asc >= -11847 and $asc <= -11056) return "Y";
        if ($asc >= -11055 and $asc <= -10247) return "Z";
        return null;
    }

    /**
     * - i.e 获取中文字符中每个中文字符的首拼.
     * - e.g. $utils->getFirstchar('你好啊') // NHA
     *
     * @param $zh
     * @return string
     */
    public function getAllFristChar($zh)
    {
        $ret = "";
        $s1  = iconv("UTF-8", "gb2312", $zh);
        $s2  = iconv("gb2312", "UTF-8", $s1);
        if ($s2 == $zh) {
            $zh = $s1;
        }
        for ($i = 0; $i < strlen($zh); $i++) {
            $s1 = substr($zh, $i, 1);
            $p  = ord($s1);
            if ($p > 160) {
                $s2  = substr($zh, $i++, 2);
                $ret .= $this->getFirstchar($s2);
            } else {
                $ret .= $s1;
            }
        }
        return $ret;
    }

    private function getEncoding($data, $to)
    {
        $encode_arr = array('UTF-8', 'ASCII', 'GBK', 'GB2312', 'BIG5', 'JIS', 'eucjp-win', 'sjis-win', 'EUC-JP');
        $encoded    = mb_detect_encoding($data, $encode_arr);
        $data       = mb_convert_encoding($data, $to, $encoded);
        return $data;
    }

    /**
     * - i.e. sql语句过滤关键字
     * - e.g.
     *
     * @param $str
     * @return mixed
     */
    public function sqlStrFilter($str)
    {
        $str = str_replace("and", "&#97;nd", $str);
        $str = str_replace("execute", "&#101;xecute", $str);
        $str = str_replace("update", "&#117;pdate", $str);
        $str = str_replace("count", "&#99;ount", $str);
        $str = str_replace("chr", "&#99;hr", $str);
        $str = str_replace("mid", "&#109;id", $str);
        $str = str_replace("master", "&#109;aster", $str);
        $str = str_replace("truncate", "&#116;runcate", $str);
        $str = str_replace("char", "&#99;har", $str);
        $str = str_replace("declare", "&#100;eclare", $str);
        $str = str_replace("select", "&#115;elect", $str);
        $str = str_replace("create", "&#99;reate", $str);
        $str = str_replace("delete", "&#100;elete", $str);
        $str = str_replace("insert", "&#105;nsert", $str);
        $str = str_replace("'", "&#39;", $str);
        $str = str_replace('"', "&#34;", $str);
        $str = str_replace("\\", "", $str);
        $str = str_replace('-', "", $str);
        $str = str_replace('/', "", $str);
        $str = str_replace('*', "", $str);

        return $str;
    }

}
