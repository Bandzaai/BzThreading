<?php
use PHPUnit\Framework\TestCase;

class FileLockTest extends TestCase
{

    /**
     *
     * @var \Bandzaai\Threading\Lock\FileLock
     */
    protected $lock;

    public function setUp()
    {
        $this->lock = \Bandzaai\Threading\Lock\FileLock::create(__FILE__);
    }

    public function tearDown()
    {
        unset($this->lock);
    }

    public function testLock()
    {
        $this->assertTrue($this->lock->acquire());
        $this->assertTrue($this->lock->release());
    }

    public function testAcquireException()
    {
        $this->setExpectedException("RuntimeException");
        $this->lock->acquire();
        $this->lock->acquire();
    }

    public function testReleaseException()
    {
        $this->setExpectedException("RuntimeException");
        $this->lock->release();
    }

    public function testCommunication()
    {
        $lock_file = "/tmp/simple-fork.lock";
        if (! file_exists($lock_file)) {
            touch($lock_file);
        }
        $process = new \Bandzaai\Threading\Process(function () use ($lock_file) {
            $lock = \Bandzaai\Threading\Lock\FileLock::create($lock_file);
            $lock->acquire(false);
            sleep(5);
            $lock->release();
        });
        $process->start();
        sleep(3);
        $lock = \Bandzaai\Threading\Lock\FileLock::create($lock_file);
        $this->assertFalse($lock->acquire(false));
        $process->wait();
        $this->assertTrue($lock->acquire(false));
        $this->assertTrue($lock->release());
    }
}