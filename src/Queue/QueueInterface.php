<?php

namespace Bandzaai\Threading\Queue;


/**
 * queue for processes to transfer data
 *
 * \Queue
 */
interface QueueInterface
{
    /**
     * put value into the queue of channel
     *
     * @param $value
     * @return bool
     */
    public function put($value);

    /**
     * get value from the queue of channel
     *
     * @param bool $block if block when the queue is empty
     * @return bool|string
     */
    public function get($block = false);
}