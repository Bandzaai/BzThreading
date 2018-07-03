<?php

use Bandzaai\Threading\Queue\PipeQueue;
use PHPUnit\Framework\TestCase;

class PipeQueueTest extends TestCase
{
    public function testAll()
    {
        $queue = new PipeQueue();
        $this->assertTrue($queue->put('test'));
        $this->assertEquals($queue->get(), 'test');
    }
}