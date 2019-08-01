<?php
/**                                                             ";
 * date: 2019/8/1
 * author: four-li
 */

namespace FourLi\Tools\Ip;


class Resolver
{
    private $ipService;

    public function __construct()
    {
        ini_set('memory_limit', '1G');

        $this->ipService = new \ipip\db\BaseStation(__DIR__ . '/ipipfree.ipdb');
    }

    /**
     * - i.e. 解析ip成省市区
     * - e.g.
     *
     * @param $ip
     * @param $type - 可选 [ string array ]
     * @return string
     */
    public function resolveIpToRegions($ip, $type = 'string')
    {
        $res = $this->ipService->findMap($ip, 'CN');
        if ($type !== 'string') return $res;
        $co = $res['country_name'] ?? '';
        $re = $res['region_name'] ?? '';
        $ci = $res['city_name'] ?? '';

        return $co . ' ' . $re . ' ' . $ci;
    }
}
