<?php
use Bandzaai\Threading\Queue\SystemVMessageQueue;
use PHPUnit\Framework\TestCase;

class SystemVMessageQueueTest extends TestCase
{

    public function testCommunication()
    {
        $process = new \Bandzaai\Threading\Process(function () {
            $queue = new SystemVMessageQueue();
            $queue->put('test');
        });
        $process->start();
        $process->wait();
        $queue = new SystemVMessageQueue();
        $this->assertEquals($queue->size(), 1);
        $this->assertEquals($queue->get(), 'test');
    }
}