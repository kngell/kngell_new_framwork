<?php

declare(strict_types=1);

class SessionFactory
{
    /**
     * Main constructor
     *  =====================================================================
     */
    public function __construct()
    {
    }

    /**
     * Create Session
     * =====================================================================
     * @param string $sessionName
     * @param string $storageString
     * @param array $options
     * @return SessionInterface
     */
    public function create(string $sessionName, string $storageString, array $options = []) :SessionInterface
    {
        $storageObject = new $storageString($options);
        if (!$storageObject instanceof SessionStorageInterface) {
            throw new SessionStorageInvalidArgument($storageString . ' is not a valid session storage object!');
        }
        return new Session($sessionName, $storageObject);
    }
}