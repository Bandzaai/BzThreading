<?php

namespace Bandzaai\Threading;


interface Runnable
{
    /**
     * process entry
     *
     * @return mixed
     */
    public function run();
}