<?php

declare(strict_types=1);

class Session implements SessionInterface
{
    /** @var SessionStorageInterface */
    protected SessionStorageInterface $storage;

    /** @var string */
    protected string $sessionIdentifier;

    /** @var const */
    protected const SESSION_PATTERN = '/^[a-zA-Z0-9_\.]{1,64}$/';

    /**
     * Class constructor
     *
     * @param string $sessionIdentifier
     * @param SessionStorageInterface $storage
     * @throws SessionInvalidArgumentException
     */
    public function __construct(string $sessionIdentifier, SessionStorageInterface $storage = null)
    {
        if ($this->isSessionKeyValid($sessionIdentifier) === false) {
            throw new SessionStorageInvalidArgument($sessionIdentifier . ' is not a valid session name');
        }

        $this->sessionIdentifier = $sessionIdentifier;
        $this->storage = $storage;
    }

    /**
     * Set Session
     * =====================================================================
     * @param string $key
     * @param mixed $value
     * @return void
     * @throws SessionException
     */
    public function set(string $key, $value): void
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            $this->storage->SetSession($key, $value);
        } catch (Throwable $throwable) {
            throw new SessionException('An exception was thrown in retrieving the key from the session storage. ' . $throwable);
        }
    }

    public function getStorage()
    {
        return $this->storage;
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
            $this->storage->deleteSession($key);
            return true;
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
        return preg_match(self::SESSION_PATTERN, $sessionName) === 1;
    }

    protected function ensureSessionKeyIsValid(string $key) : void
    {
        if ($this->isSessionKeyValid($key) === false) {
            throw new SessionInvalidArgument($key . ' is not a valid sesion Name.');
        }
    }

    /**
     * Get User Agent client
     *
     * @return void
     */
    public static function uagent_no_version()
    {
        $uagent = $_SERVER['HTTP_USER_AGENT'];
        $regx = '/\/[a-zA-z0-9.]+/';
        $newString = preg_replace($regx, '', $uagent);
        return $newString;
    }
}