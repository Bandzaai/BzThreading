<?php

namespace Bandzaai\Threading;

/**
 * pool
 *
 * 
 */
class Pool extends AbstractPool
{

    /**
     * add a process
     *
     * @param Process $process
     * @param null|string $name
     *            process name
     * @return int
     */
    public function execute(Process $process, $name = null)
    {
        if (! is_null($name)) {
            $process->name($name);
        }
        if (! $process->isStarted()) {
            $process->start();
        }
        
        return array_push($this->processes, $process);
    }
}