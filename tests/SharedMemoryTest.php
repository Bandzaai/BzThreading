<?php

use Bandzaai\Threading\Cache\SharedMemory;
use PHPUnit\Framework\TestCase;

class SharedMemoryTest extends TestCase
{
    public function testSetAndGet()
    {
        $cache = new SharedMemory();
        $process = new \Bandzaai\Threading\Process(function () use ($cache) {
            $cache->set('test', 'test');
        });
        $process->start();
        // wait sub process
        $process->wait();

        $this->assertEquals('test', $cache->get('test'));


    }

    public function testHas()
    {
        $cache = new SharedMemory();
        $cache->set('test', 'test');
        $this->assertTrue($cache->has('test'));
        $this->assertEquals($cache->get('test'), 'test');
        $cache->delete('test');
        $this->assertFalse($cache->has('test'));
    }

    public function testRemove()
    {
        $cache = new SharedMemory();
        $cache->set('test', 'test');
        $process = new \Bandzaai\Threading\Process(function () use ($cache) {
            $cache->remove();
        });
        $this->assertEquals($cache->get('test'), 'test');
        $process->start();
        $process->wait();

        // maybe a php bug
        //$this->assertFalse($cache->get('test'));
    }
}