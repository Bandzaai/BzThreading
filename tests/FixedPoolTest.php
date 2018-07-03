<?php
use PHPUnit\Framework\TestCase;

class FixedPoolTest extends TestCase
{

    public function testAliveCount()
    {
        $pool = \Bandzaai\Threading\PoolFactory::newFixedPool(4);
        $pool->execute(new FixedPoolTestProcess());
        $pool->execute(new FixedPoolTestProcess());
        $pool->execute(new FixedPoolTestProcess());
        $pool->execute(new FixedPoolTestProcess());
        
        $pool->execute(new FixedPoolTestProcess());
        $pool->execute(new FixedPoolTestProcess());
        $pool->execute(new FixedPoolTestProcess());
        $pool->execute(new FixedPoolTestProcess());
        
        $this->assertEquals(4, $pool->aliveCount());
        sleep(4);
        $pool->wait();
        $this->assertEquals(4, $pool->aliveCount());
        $pool->wait(true);
        $this->assertEquals(0, $pool->aliveCount());
    }
}

class FixedPoolTestProcess extends \Bandzaai\Threading\Process
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