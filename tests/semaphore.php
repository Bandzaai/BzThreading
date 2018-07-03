<?php

use Bandzaai\Threading\Lock\Semaphore;

require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$process = new \Bandzaai\Threading\Process(function () {
    $lock = Semaphore::create('test');
    var_dump($lock->acquire());
    sleep(5);
    var_dump($lock->release());
});
$process->start();
sleep(3);
$lock = Semaphore::create("test");
$this->assertFalse($lock->acquire());
$process->wait();
$this->assertTrue($lock->acquire());
$this->assertTrue($lock->release());