<?php

include_once __DIR__ . '/../../vendor/autoload.php';

$ipService = new FourLi\Tools\Ip\Resolver();

$ret = $ipService->resolveIpToRegions('60.1.2.1');

var_dump($ret);
