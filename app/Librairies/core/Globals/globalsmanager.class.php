<?php

declare(strict_types=1);

class GlobalsManager implements GlobalsManagerInterface
{
    /**
     * Set Globals
     * =====================================================================
     * @param string $key
     * @param [type] $value
     * @return void
     */
    public static function set(string $key, $value) :void
    {
        $GLOBALS[$key] = $value;
    }

    /**
     * Get Globals
     * =====================================================================
     * @param string $key
     * @return void
     * @throws GlobalManagerInvalidException
     */
    public static function get(string $key)
    {
        self::isglobalsValid($key);
        try {
            return $GLOBALS[$key];
        } catch (\Throwable $th) {
            throw new GlobalsManagerExceptions('An exception occured trying to retrieve Globals! ' . $key);
        }
    }

    /**
     * Check for Valid globals key and not empty
     * =====================================================================
     * @param string $key
     * @return void
     * @throws GlobalManagerInvalidException
     */
    private static function isglobalsValid(string $key) :void
    {
        if (!isset($GLOBALS[$key])) {
            throw new GlobalManagerInvalidException('Invalid Globals Key! ' . $key);
        }
        if (empty($key)) {
            throw new GlobalManagerInvalidException('Empty key is not allowed! ' . $key);
        }
    }
}