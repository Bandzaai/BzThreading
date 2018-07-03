<?php
namespace Bandzaai\Threading;

class PoolFactory
{

    /**
     * create a pool instance
     *
     * @return Pool
     */
    public static function newPool()
    {
        return new Pool();
    }

    /**
     * create a fixed pool instance
     *
     * @param int $max
     * @return FixedPool
     */
    public static function newFixedPool($max = 4)
    {
        return new FixedPool($max);
    }

    /**
     * create a parallel pool instance
     *
     * @param
     *            $callback
     * @param int $max
     * @return ParallelPool
     */
    public static function newParallelPool($callback, $max = 4)
    {
        return new ParallelPool($callback, $max);
    }

    /**
     * create a single pool
     *
     * @return SinglePool
     */
    public static function newSinglePool()
    {
        return new SinglePool();
    }
}