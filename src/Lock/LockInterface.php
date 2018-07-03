<?php

namespace Bandzaai\Threading\Lock;


/**
 * lock for processes to mutual exclusion
 *
 * \Lock
 */
interface LockInterface
{
    /**
     * get a lock
     *
     * @param bool $blocking
     * @return bool
     */
    public function acquire($blocking = true);

    /**
     * release lock
     *
     * @return bool
     */
    public function release();

    /**
     * is locked
     *
     * @return bool
     */
    public function isLocked();
}