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
