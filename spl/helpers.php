<?php

if (!function_exists('decodeDsn')) {
    /**
     * - i.e. 将symfony .env设置中的dsn字符串解析成数组
     * - e.g.
     *
     * @param $dsn
     * @return array
     */
    function decodeDsn($dsn)
    {
        $info = parse_url($dsn);
        if ($info['scheme']) {
            $dsn = array(
                'dbms'     => $info['scheme'],
                'username' => isset($info['user']) ? $info['user'] : '',
                'password' => isset($info['pass']) ? $info['pass'] : '',
                'hostname' => isset($info['host']) ? $info['host'] : '',
                'hostport' => isset($info['port']) ? $info['port'] : '',
                'database' => isset($info['path']) ? substr($info['path'], 1) : ''
            );
        } else {
            preg_match('/^(.*?)\:\/\/(.*?)\:(.*?)\@(.*?)\:([0-9]{1, 6})\/(.*?)$/', trim($dsn), $matches);
            $dsn = array(
                'dbms'     => $matches[1],
                'username' => $matches[2],
                'password' => $matches[3],
                'hostname' => $matches[4],
                'hostport' => $matches[5],
                'database' => $matches[6]
            );
        }

        $option = [
            'database_type' => $dsn['dbms'],
            'database_name' => $dsn['database'],
            'server'        => $dsn['hostname'],
            'username'      => $dsn['username'],
            'password'      => $dsn['password'],
            'charset'       => 'utf8',
            'port'          => $dsn['hostport'],
        ];

        return $option;
    }
}


if (!function_exists('varIsEmpty')) {
    /**
     * - i.e. 参数非空
     * - e.g.
     *
     * @param $var
     * @return bool
     */
    function varIsEmpty($var)
    {
        if (!$var && $var !== 0 && $var !== '0' && $var !== 0.00 && $var !== 0.000 && $var !== '0.00' && $var !== '0.000') {
            return false;
        }
        return true;
    }
}

if (!function_exists('moneyFormatter')) {
    /**
     * - i.e. 格式化钱
     * - e.g. moneyFormatter(100.1123, $format = 2, $prefix = '¥')  =>  ¥ 100.11
     *
     * @param      $money
     * @param int  $format
     * @param null $prefix
     * @return float|string
     */
    function moneyFormatter($money, $format = 2, $prefix = null)
    {
        if (!$money || !is_numeric($money)) $money = 0.00;

        return $prefix ? (string)$prefix . sprintf("%." . $format . "f", $money) : (float)sprintf("%." . $format . "f", $money);
    }
}

if (!function_exists('trimAll')) {
    /**
     * - i.e. 递归trim
     * - e.g.
     *
     * @param $data array|string
     * @return array|string
     */
    function trimAll($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $item) {
                if (is_array($item)) {
                    $data[$key] = trimAll($item);
                } else {
                    $data[$key] = trim($item);
                }
            }
        } else {
            $data = trim($data);
        }

        return $data;
    }
}

if (!function_exists('convertSetGet')) {
    // 处理数据  如 将'user_name' =>  getUserName
    function convertSetGet($str, $action = 'get')
    {
        if (strpos($str, '_')) {
            $arr    = explode('_', $str);
            $newStr = $action;
            foreach ($arr as $k => $v) {
                $newStr .= ucfirst($v);
            }
        } else {
            $newStr = $action . ucfirst($str);
        }

        return $newStr;
    }
}

if (!function_exists('handleArraySetEntity')) {
    /**
     * ~ i.e. 将对象循环设置set字段
     * ~ e.g.
     *
     * @param $entity
     * @param $set
     * @return object
     */
    function handleArraySetEntity($entity, $set)
    {
        if (is_object($entity)) {
            foreach ($set as $kSon => $vSon) {
                // 转换成想要的格式 如 user_name -> setUserName
                $action = 'set' . formartCaps($kSon);
                $entity->$action($vSon);
            }
        }

        return $entity;
    }
}

if (!function_exists('formartCaps')) {
    /**
     * - i.e. 格式化字符串 首字母大写
     * - e.g.
     *
     * @param      $str  - 需要转换的字符串
     * @param bool $mask - 是否小驼峰  默认大驼峰
     * @return string
     */
    function formartCaps($str, $mask = false)
    {
        if (strpos($str, '_')) {
            $arr = explode('_', $str);

            $newStr = '';
            foreach ($arr as $k => $v) {
                if ($k === 0 && $mask == true) {
                    $newStr .= $v;
                    continue;
                }
                $newStr .= ucfirst($v);
            }
        } else {
            if (!$mask) $newStr = ucfirst($str);
        }

        return $newStr;
    }
}

if (!function_exists('getMicroSecond')) {
    # 当前时间戳毫秒
    function getMicroSecond()
    {
        list($msec, $sec) = explode(' ', microtime());
        $msectime = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);

        return $msectime;
    }
}

if (!function_exists('explodeStr')) {
    /**
     * ~ i.e. 将逗号、空格、回车分隔的字符串转换为数组的函数
     * ~ e.g.
     *
     * @param $strs
     * @return array
     */
    function explodeStr($strs)
    {
        $result = array();
        $strs   = str_replace('，', ',', $strs);
        $strs   = str_replace(',', ',', $strs);
        $strs   = str_replace("\n", ',', $strs);
        $strs   = str_replace("\r", ',', $strs);
        $strs   = str_replace("\t", ',', $strs);
        $strs   = str_replace(' ', ',', $strs);
        $array  = explode(',', $strs);

        foreach ($array as $key => $value) {
            if ('' != ($value = trim($value))) {
                $result[] = $value;
            }
        }
        return $result;
    }
}

if (!function_exists('computePer')) {
    /**
     * ~ i.e. 计算百分比
     * ~ e.g.
     *
     * @param int $numerator   分子
     * @param int $denominator 分母
     * @return int
     */
    function computePer(int $numerator, int $denominator = 100, $float = 2)
    {
        return round(($numerator / $denominator) * 100, $float);
    }
}

if (!function_exists('inStr')) {
    /**
     * - i.e. 搜索一段字符串是否在另一串字符串中出现
     * - e.g.
     *
     * @param $search
     * @param $haystack
     * @return bool
     */
    function inStr($search, $haystack): bool
    {
        if (strpos($haystack, strval($search)) === false) {
            return false;
        } else {
            return true;
        }
    }
}

if (!function_exists('toRoute')) {
    # 跳转路由
    function toRoute($url)
    {
        echo sprintf(
            '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="refresh" content="0;url=%1$s" />
</head>
</html>', htmlspecialchars($url, ENT_QUOTES, 'UTF-8'));
        die;
    }
}

# 跳转路由
function toRoute($url)
{
    echo sprintf(
        '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="refresh" content="0;url=%1$s" />
</head>
</html>', htmlspecialchars($url, ENT_QUOTES, 'UTF-8'));
    die;
}

if (!defined('ENCRYPT_DEFAULT_KEY')) define('ENCRYPT_DEFAULT_KEY', 'zfi-0o.`;=');

if (!defined('ENCRYPT_IV_STR')) define('ENCRYPT_IV_STR', 'four.li-……&%*riS%23())*(^&123!23');

if (!function_exists('opensslEncode')) {
    # 字符串openssl加密
    function opensslEncode($strData): string
    {
        $openssl_method = 'AES-256-CBC';
        $openssl_iv     = substr(ENCRYPT_IV_STR, 0, 16); # 16位

        $openssl_password = substr(md5(ENCRYPT_DEFAULT_KEY), 0, 16);
        # 加密
        return openssl_encrypt($strData, $openssl_method, $openssl_password, 0, $openssl_iv);
    }
}

if (!function_exists('opensslDecode')) {
# 字符串openssl解密密
    function opensslDecode($strData): string
    {
        $openssl_method = 'AES-256-CBC';
        $openssl_iv     = substr(ENCRYPT_IV_STR, 0, 16); # 16位

        $openssl_password = substr(md5(ENCRYPT_DEFAULT_KEY), 0, 16);
        return openssl_decrypt($strData, $openssl_method, $openssl_password, 0, $openssl_iv);
    }
}

if (!function_exists('__encrypt')) {
    # 数组加密为字符串
    function __encrypt(array $data, string $key = '', int $expire = 0): string
    {
        $key  = md5(empty($key) ? ENCRYPT_DEFAULT_KEY : $key);
        $data = base64_encode(json_encode($data));
        $x    = 0;
        $len  = strlen($data);
        $l    = strlen($key);
        $char = '';

        for ($i = 0; $i < $len; $i++) {
            if ($x == $l)
                $x = 0;
            $char .= substr($key, $x, 1);
            $x++;
        }

        $str = sprintf('%010d', $expire ? $expire + time() : 0);

        for ($i = 0; $i < $len; $i++) {
            $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1))) % 256);
        }
        return str_replace(array(
            '+',
            '/',
            '='
        ), array(
            '-',
            '_',
            ''
        ), base64_encode($str));
    }
}

if (!function_exists('__decrypt')) {
    # 解密成数组
    function __decrypt(string $data, string $key = '')
    {
        $key  = md5(empty($key) ? ENCRYPT_DEFAULT_KEY : $key);
        $data = str_replace(array(
            '-',
            '_'
        ), array(
            '+',
            '/'
        ), $data);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        $data   = base64_decode($data);
        $expire = substr($data, 0, 10);
        $data   = substr($data, 10);

        if ($expire > 0 && $expire < time()) {
            return null;
        }
        $x    = 0;
        $len  = strlen($data);
        $l    = strlen($key);
        $char = $str = '';

        for ($i = 0; $i < $len; $i++) {
            if ($x == $l)
                $x = 0;
            $char .= substr($key, $x, 1);
            $x++;
        }

        for ($i = 0; $i < $len; $i++) {
            if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
                $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
            } else {
                $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
            }
        }
        return json_decode(base64_decode($str), true);
    }
}


if (!function_exists('cdebug')) {
    function cdebug($message = '', $context = [])
    {
        $debugMsg  = debug_backtrace();
        $file      = $debugMsg[0]['file'];
        $line      = $debugMsg[0]['line'];
        $debugData = [
            'channel' => 'middebuger',
            'date'    => date('Y-m-d H:i:s'),
            'msg'     => $message,
            'context' => $context,
            'file'    => $file,
            'line'    => $line,
        ];

        $filePath = '/tmp/cdebug.log';

        file_put_contents($filePath, json_encode($debugData, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
    }
}
