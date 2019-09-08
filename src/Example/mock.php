<?php

include_once __DIR__ . '/../../vendor/autoload.php';


$client = new \FourLi\Tools\Mock\CnDataMock();

$userInfo['name'] = $client->getName();

$userInfo['sign'] = $client->getText();

$userInfo['mobile'] = $client->getMobile();

$userInfo['email'] = $client->getEmail();

$userInfo['no'] = $client->getNodeNo(40);

$userInfo['str'] = $client->getRandomStr(20, true, true, true);

$userInfo['avatar'] = $client->getAvatar();

print_r($userInfo);
