<?php
namespace Bandzaai\Threading\Cache;

/**
 * cache for processes shared variables
 *
 * \Cache
 */
interface CacheInterface
{

    /**
     * get var
     *
     * @param $key
     * @param null $default
     * @return bool|mixed
     */
    public function get($key, $default = null);

    /**
     * set var
     *
     * @param $key
     * @param null $value
     * @return
     */
    public function set($key, $value);

    /**
     * has var ?
     *
     * @param $key
     * @return bool
     */
    public function has($key);

    /**
     * delete var
     *
     * @param $key
     * @return bool
     */
    public function delete($key);

}