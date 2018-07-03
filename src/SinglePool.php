<?php
namespace Bandzaai\Threading;


/**
 * Only one process will be started at the same time
 *
 * 
 */
class SinglePool extends FixedPool
{
    /**
     * SinglePool constructor.
     */
    public function __construct()
    {
        parent::__construct(1);
    }
}