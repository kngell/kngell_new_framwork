<?php

declare(strict_types=1);

interface SessionInterface
{
    /**
     * Set Session
     * --------------------------------------------------------------------------------------------------
     * @param string $key
     * @param [type] $value
     * @return void
     */
    public function set(string $key, $value) :void;

    /**
     * Set Array Session
     * --------------------------------------------------------------------------------------------------
     * @param string $key
     * @param [type] $value
     * @return void
     */
    public function setArray(string $key, $value) :void;

    /**
     * Get Session
     * --------------------------------------------------------------------------------------------------
     * @param string $key
     * @param [type] $default
     * @return void
     */
    public function get(string $key, $default = null);

    /**
     * Delete Session
     * --------------------------------------------------------------------------------------------------
     * @param string $key
     * @return boolean
     */
    public function delete(string $key) :bool;

    /**
     * Invalidate a Session
     * --------------------------------------------------------------------------------------------------
     * @return void
     */
    public function invalidate() :void;

    /**
     * Flush Session
     * --------------------------------------------------------------------------------------------------
     * @param string $key
     * @param [type] $value
     * @return void
     */
    public function flush(string $key, $value = null);

    /**
     * Check if Session exists
     *--------------------------------------------------------------------------------------------------
     * @param string $key
     * @return boolean
     */
    public function exists(string $key) : bool;
}