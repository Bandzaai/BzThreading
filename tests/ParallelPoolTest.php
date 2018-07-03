<?php
use Bandzaai\Threading\ParallelPool;
use Bandzaai\Threading\Runnable;
use PHPUnit\Framework\TestCase;

class ParallelPoolTest extends TestCase
{

    public function testAll()
    {
        $pool = new ParallelPool(new ParallelPoolTestRunnable(), 10);
        $pool->start();
        $this->assertEquals(10, $pool->aliveCount());
        sleep(4);
        $this->assertEquals(0, $pool->aliveCount());
        $pool->keep();
        $this->assertEquals(10, $pool->count());
        $this->assertEquals(10, $pool->aliveCount());
        $pool->wait(true);
    }

    public function testException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $pool = new ParallelPool('test');
    }

    public function testReload()
    {
        $pool = new ParallelPool(new ParallelPoolTestRunnable(), 10);
        $pool->start();
        $this->assertEquals(10, $pool->aliveCount());
        $old_processes = $pool->getProcesses();
        $pool->reload();
        $new_processes = $pool->getProcesses();
        foreach ($old_processes as $old_process) {
            foreach ($new_processes as $new_process) {
                $this->assertTrue($old_process->getPid() != $new_process->getPid());
            }
        }
        $pool->shutdown();
    }
}

class ParallelPoolTestRunnable implements Runnable
{

    /**
     * process entry
     *
     * @return mixed
     */
    public function run()
    {
        sleep(3);
    }
}