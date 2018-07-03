<?php

use PHPUnit\Framework\TestCase;
use Bandzaai\Threading\Cache\RedisCache;

class RedisCacheTest extends TestCase
{
    /**
     * @var RedisCache
     */
    protected $cache;

    public function testAll()
    {
        if(!extension_loaded("Redis")){
            $this->markTestSkipped("Redis extension is not loaded");
        }
        $this->cache = new RedisCache();
        $this->cache->set('cache', 'test');
        $this->assertTrue($this->cache->has('cache'));
        $this->assertEquals($this->cache->get('cache'), 'test');
        $this->assertTrue($this->cache->delete('cache'));
        $this->assertNull($this->cache->get('cache'));
        $this->cache->close();
    }

}