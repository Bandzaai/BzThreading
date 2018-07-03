<?php

use Bandzaai\Threading\Queue\RedisQueue;
use PHPUnit\Framework\TestCase;

class RedisQueueTest extends TestCase
{
    /**
     * @var RedisQueue
     */
    protected $queue;

    public function testAll()
    {
        if(!extension_loaded("Redis")){
            $this->markTestSkipped("Redis extension is not loaded");
        }
        $this->queue = new RedisQueue();
        $this->assertTrue($this->queue->put('test'));
        $this->assertEquals($this->queue->get(), 'test');
        $this->assertEquals($this->queue->size(), 0);
        $this->queue->close();
    }

    public function testCommunication()
    {
        if(!extension_loaded("Redis")){
            $this->markTestSkipped("Redis extension is not loaded");
        }
        $process = new \Bandzaai\Threading\Process(function () {
            $queue = new RedisQueue();
            $queue->put('test');
            $queue->close();
        });
        $process->start();
        $process->wait();
        $queue = new RedisQueue();
        $this->assertEquals($queue->size(), 1);
        $this->assertEquals($queue->get(), 'test');
        $queue->close();
    }

}