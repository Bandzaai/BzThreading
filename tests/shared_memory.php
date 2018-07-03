<?php

use Bandzaai\Threading\Cache\SharedMemory;

require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$cache = new SharedMemory();
$cache->set('test', 'test');

var_dump($cache->remove());
var_dump($cache->get('test'));



