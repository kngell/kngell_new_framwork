<?php

declare(strict_types=1);

class NativeSessionStorage extends AbstractSessionStorage
{
    public function __construct(array $options = [])
    {
        parent::__construct($options);
    }

    /**
     * Set Session
     * =====================================================================
     * @param string $key
     * @param [type] $value
     * @return void
     */
    public function setSession(string $key, $value) :void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Set Array Session
     *=====================================================================
     * @param string $key
     * @param [type] $value
     * @return void
     */
    public function setArraySession(string $key, $value) :void
    {
        $_SESSION[$key][] = $value;
    }

    /**
     * Get Session
     *=====================================================================
     * @param string $key
     * @param [type] $default
     * @return void
     */
    public function getSession(string $key, $default = null)
    {
        if ($this->SessionExists($key)) {
            return $_SESSION[$key];
        }
        return $default;
    }

    public function deleteSession(string $key) :void
    {
        if ($this->SessionExists($key)) {
            unset($_SESSION[$key]);
        }
    }

    public function SessionExists(string $key) :bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     *Flush the Session
     *=====================================================================
     * @param string $key
     * @param [type] $default
     * @return void
     */
    public function flushSession(string $key, $default)
    {
        if ($this->SessionExists($key)) {
            $value = $_SESSION[$key];
            $this->deleteSession($key);
            return $value;
        }
        return $default;
    }

    /**
     * Invalidate a session
     *=====================================================================
     * @return void
     */
    public function invalidateSession() : void
    {
        $_SESSION = [];
        if (ini_set('session.use_cookies', $this->options['use_cookies'])) {
            $params = session_get_cookie_params();
            setcookie($this->getSessionName(), '', time() - $params['lifetime'], $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_unset();
        session_destroy();
    }
}