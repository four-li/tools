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


