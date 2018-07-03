<?php
use Bandzaai\Threading\Pool;
use Bandzaai\Threading\Process;

require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$pool = new Pool();
for ($i = 0; $i < 100; $i++) {
    $process = new Process(function () {
        sleep(30);
        echo getmypid() . PHP_EOL;
    });
    $pool->execute($process);
}
$pool->wait();