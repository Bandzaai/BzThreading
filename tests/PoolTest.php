<?php
use Bandzaai\Threading\Pool;
use PHPUnit\Framework\TestCase;

class PoolTest extends TestCase
{

    public function testMethods()
    {
        $process = new \Bandzaai\Threading\Process(function () {
            sleep(3);
        }, 'test');
        $pool = new Pool();
        $pool->execute($process);
        $this->assertEquals(1, $pool->aliveCount());
        $this->assertEquals($process, $pool->getProcessByPid($process->getPid()));
        $this->assertEquals($process, $pool->getProcessByName('test'));
    }

    public function testAliveCount()
    {
        $pool = new Pool();
        for ($i = 0; $i < 10; $i ++) {
            $process = new \Bandzaai\Threading\Process(function () {
                sleep(3);
            });
            $pool->execute($process);
        }
        $start = time();
        $this->assertEquals(10, $pool->aliveCount());
        $pool->wait();
        $time = time() - $start;
        $this->assertTrue($time >= 3);
        $this->assertEquals(0, $pool->aliveCount());
    }

    public function testShutdown()
    {
        $pool = new Pool();
        for ($i = 0; $i < 10; $i ++) {
            $process = new \Bandzaai\Threading\Process(function () {
                sleep(3);
            });
            $pool->execute($process);
        }
        $start = time();
        $pool->shutdown();
        $time = time() - $start;
        $this->assertTrue($time < 3);
        $this->assertEquals(0, $pool->aliveCount());
    }

    public function testShutdownForce()
    {
        $pool = new Pool();
        for ($i = 0; $i < 10; $i ++) {
            $process = new \Bandzaai\Threading\Process(function () {
                sleep(3);
            });
            $pool->execute($process);
        }
        $start = time();
        $pool->shutdownForce();
        $time = time() - $start;
        $this->assertTrue($time < 3);
        $this->assertEquals(0, $pool->aliveCount());
    }
}