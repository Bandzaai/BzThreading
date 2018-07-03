<?php

use Bandzaai\Threading\Utils;
use PHPUnit\Framework\TestCase;

class UtilsTest extends TestCase
{
    public function testCheck()
    {
        $process = new UtilsTestProcess();
        Utils::checkOverwriteRunMethod(get_class($process));
    }

    public function testError(){
        $this->setExpectedException("RuntimeException");
        Utils::checkOverwriteRunMethod(get_class(new \Bandzaai\Threading\Process()));
    }
}

class UtilsTestProcess extends \Bandzaai\Threading\Process
{
    public function run()
    {
        echo 'run' . PHP_EOL;
    }
}