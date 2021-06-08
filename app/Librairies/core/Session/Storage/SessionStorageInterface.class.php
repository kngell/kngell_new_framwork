<?php

declare(strict_types=1);

interface SessionStorageInterface
{
    /**
     * Set Session Name
     * --------------------------------------------------------------------------------------------------
     * @param string $sessionName
     * @return void
     */
    public function setSessionName(string $sessionName) :void;

    /**
     * Get Session Name
     * --------------------------------------------------------------------------------------------------
     * @return string
     */
    public function getSessionName() : string;

    /**
     * Set Session ID
     * --------------------------------------------------------------------------------------------------
     * @param string $sessionID
     * @return void
     */
    public function setSessionID(string $sessionID) :void;

    /**
     * Get Session
     * --------------------------------------------------------------------------------------------------
     * @return void
     */
    public function getSessionID();

    /**
     * Set Session
     * --------------------------------------------------------------------------------------------------
     * @param string $key
     * @param [type] $value
     * @return void
     */
    public function setSession(string $key, $value) :void;

    /**
     * Set Array of Session
     * --------------------------------------------------------------------------------------------------
     * @param string $key
     * @param [type] $value
     * @return void
     */
    public function setArraySession(string $key, $value) :void;

    /**
     * Get Session
     * --------------------------------------------------------------------------------------------------
     * @param string $key
     * @param [type] $default
     * @return void
     */
    public function getSession(string $key, $default = null);

    /**
     * Delete Session
     * --------------------------------------------------------------------------------------------------
     * @param string $key
     * @return boolean
     */
    public function deleteSession(string $key) :void;

    /**
     * Check for exists Session
     * --------------------------------------------------------------------------------------------------
     * @param string $key
     * @return boolean
     */
    public function SessionExists(string $key) :bool;

    /**
     * Flush Session
     * --------------------------------------------------------------------------------------------------
     * @param string $key
     * @param [type] $default
     * @return void
     */
    public function flushSession(string $key, $default);

    /**
     * Invalidate Session
     * --------------------------------------------------------------------------------------------------
     * @return void
     */
    public function invalidateSession() : void;
}