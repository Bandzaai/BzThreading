<?php
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$lock_file = "/tmp/simple-fork.lock";
if (!file_exists($lock_file)) {
    touch($lock_file);
}
$process = new \Bandzaai\Threading\Process(function () use ($lock_file) {
    $lock = \Bandzaai\Threading\Lock\FileLock::create($lock_file);
    echo getmypid() . PHP_EOL;
    var_dump($lock->acquire());
    sleep(5);
    echo getmypid() . PHP_EOL;
    var_dump($lock->release());
});
$process->start();
sleep(3);
$lock = \Bandzaai\Threading\Lock\FileLock::create($lock_file);
echo getmypid() . PHP_EOL;
var_dump($lock->acquire());
$process->wait();
echo getmypid() . PHP_EOL;
var_dump($lock->acquire());
echo getmypid() . PHP_EOL;
var_dump($lock->release());