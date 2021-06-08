<?php

declare(strict_types=1);

class Session implements SessionInterface
{
    protected SessionStorageInterface $storage;
    protected string $sessionName;
    protected const SESSION_PATERN = '/^|[a-zA-Z0-9_\.]{1,64}$/';

    public function __construct(string $sessionName, SessionStorageInterface $storage = null)
    {
        if ($this->isSessionKeyValid($sessionName) === false) {
            throw new SessionInvalidArgument($sessionName . ' is not a valid Session name');
        }
        $this->sessionName = $sessionName;
        $this->storage = $storage;
    }

    /**
     * Set Session
     * =====================================================================
     * @param string $key
     * @param [type] $value
     * @return void
     */
    public function set(string $key, $value): void
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            $this->storage->setSession($key, $value);
        } catch (\Throwable $th) {
            throw new SessionException('An exception as occured when retrieving the key from Session storage. ' . $th);
        }
    }

    /**
     * Set Array Session
     * =====================================================================
     * @param string $key
     * @param [type] $value
     * @return void
     */
    public function setArray(string $key, $value): void
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            $this->storage->setArraySession($key, $value);
        } catch (\Throwable $th) {
            throw new SessionException('An error as occured when retrieving the key from Session storage. ' . $th);
        }
    }

    /**
     * Get Session
     * =====================================================================
     * @param string $key
     * @param [type] $default
     * @return void
     */
    public function get(string $key, $default = null)
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            return $this->storage->getSession($key, $default);
        } catch (\Throwable $th) {
            throw new SessionException();
        }
    }

    /**
     * Delete Session
     * =====================================================================
     * @param string $key
     * @return boolean
     */
    public function delete(string $key): bool
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            return $this->storage->deleteSession($key);
        } catch (\Throwable $th) {
            throw new SessionException();
        }
    }

    /**
     * Invalidate Session
     * =====================================================================
     * @return void
     */
    public function invalidate(): void
    {
        $this->storage->invalidateSession();
    }

    /**
     * Flush the session
     * =====================================================================
     * @param string $key
     * @param [type] $value
     * @return void
     */
    public function flush(string $key, $value = null)
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            $this->storage->flushSession($key, $value);
        } catch (\Throwable $th) {
            throw new SessionException();
        }
    }

    /**
     * Check for existing Session
     * =====================================================================
     * @param string $key
     * @return boolean
     */
    public function exists(string $key): bool
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            return $this->storage->SessionExists($key);
        } catch (\Throwable $th) {
            throw new SessionException();
        }
    }

    /**
     * Check for valid session key
     *
     * @param string $sessionName
     * @return boolean
     */
    protected function isSessionKeyValid(string $sessionName) : bool
    {
        return preg_match(self::SESSION_PATERN, $sessionName) === 1;
    }

    protected function ensureSessionKeyIsValid(string $key) : void
    {
        if ($this->isSessionKeyValid($key) === false) {
            throw new SessionInvalidArgument($key . ' is not a valid sesion Name.');
        }
    }
}