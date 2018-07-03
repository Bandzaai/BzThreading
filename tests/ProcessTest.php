<?php
use Bandzaai\Threading\Runnable;
use PHPUnit\Framework\TestCase;

class ProcessTest extends TestCase
{

    /**
     *
     * @var \Bandzaai\Threading\Process
     */
    protected $process_thread;

    /**
     *
     * @var \Bandzaai\Threading\Process
     */
    protected $process_runnable;

    /**
     *
     * @var \Bandzaai\Threading\Process
     */
    protected $process_callback;

    public function testFailed()
    {
        $process = new \Bandzaai\Threading\Process(function () {
            exit(255);
        });
        $process->start();
        $process->wait();
        $this->assertEquals(255, $process->errno());
        $this->assertEquals("Unknown error 255", $process->errmsg());
    }

    public function testShutdown()
    {
        $process = new \Bandzaai\Threading\Process(function () {
            sleep(3);
        });
        $time = time();
        $process->start();
        $process->shutdown(SIGKILL);
        $this->assertFalse($process->isRunning());
        $this->assertTrue(time() - $time < 3);
        $this->assertTrue($process->ifSignal());
        $this->assertEquals(0, $process->errno());
    }

    public function testWait()
    {
        $this->process_thread = new MyThread();
        $this->process_runnable = new \Bandzaai\Threading\Process(new MyRunnable());
        $this->process_callback = new \Bandzaai\Threading\Process(function () {
            for ($i = 0; $i < 3; $i ++) {
                // echo "callback pid:" . getmypid() . PHP_EOL;
            }
        });
        $this->process_thread->start();
        $this->process_thread->wait();
        $this->assertEquals(0, $this->process_thread->errno());
        $this->assertEquals($this->process_thread->errno(), 0);
        $this->assertEquals($this->process_thread->errmsg(), 'Success');
        $this->assertEquals($this->process_thread->isRunning(), false);
        
        $this->process_runnable->start();
        $this->process_runnable->wait();
        $this->assertEquals(0, $this->process_runnable->errno());
        
        $this->process_callback->start();
        $this->process_callback->wait();
        $this->assertEquals(0, $this->process_callback->errno());
    }
}

class MyThread extends \Bandzaai\Threading\Process
{

    public function run()
    {
        for ($i = 0; $i < 3; $i ++) {
            // echo "thread pid:" . getmypid() . PHP_EOL;
        }
    }
}

class MyRunnable implements Runnable
{

    /**
     * process entry
     *
     * @return mixed
     */
    public function run()
    {
        for ($i = 0; $i < 3; $i ++) {
            // echo "runnable pid:" . getmypid() . PHP_EOL;
        }
    }
}