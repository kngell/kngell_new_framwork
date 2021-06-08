<?php

declare(strict_types=1);

interface GlobalsManagerInterface
{
    /**
     * Set globals Variables
     * --------------------------------------------------------------------------------------------------
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set(string $key, $value) :void;

    /**
     * Get Globals
     * --------------------------------------------------------------------------------------------------
     * @param string $key
     * @return void
     */
    public static function get(string $key);
}