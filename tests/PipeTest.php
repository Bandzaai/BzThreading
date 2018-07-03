<?php
use Bandzaai\Threading\Queue\Pipe;
use PHPUnit\Framework\TestCase;

class PipeTest extends TestCase
{

    public function testRead()
    {
        $process = new \Bandzaai\Threading\Process(function () {
            $pipe = new Pipe();
            $pipe->write('test');
            sleep(2);
            $pipe->close();
        });
        $process->start();
        sleep(1);
        $pipe = new Pipe();
        $this->assertEquals('test', $pipe->read());
        $process->wait(true);
        $pipe->close();
    }

    public function testWrite()
    {
        $pipe = new Pipe();
        $this->assertEquals(4, $pipe->write('test'));
        
        $process = new \Bandzaai\Threading\Process(function () {
            $pipe = new Pipe();
            $pipe->read();
            $pipe->close();
        });
        $process->start();
        $process->wait(true);
        $pipe->close();
    }

    public function testBlock()
    {
        $pipe = new Pipe();
        $pipe->setBlock(true);
        $process = new \Bandzaai\Threading\Process(function () {
            $pipe = new Pipe();
            sleep(2);
            $pipe->write('test');
            $pipe->close();
        });
        $start = time();
        $process->start();
        $this->assertEquals('test', $pipe->read(4));
        $end = time();
        $this->assertTrue(($end - $start) >= 2);
        $process->wait(true);
    }
}