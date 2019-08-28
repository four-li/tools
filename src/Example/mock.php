<?php

include_once __DIR__ . '/../../vendor/autoload.php';


$client = new \FourLi\Tools\Mock\CnDataMock();

$userInfo['name'] = $client->getName();

$userInfo['sign'] = $client->getText();

$userInfo['mobile'] = $client->getMobile();

var_dump($userInfo);
