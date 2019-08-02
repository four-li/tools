<?php

include_once __DIR__ . '/../../vendor/autoload.php';

$utils = new \FourLi\Tools\Utils\StrHandler();

$ret = $utils->getAllFristChar('烽');

var_dump($ret);
