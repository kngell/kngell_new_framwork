<?php

declare(strict_types=1);

class SessionFactory
{
    protected ContainerInterface $container;

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
        $storageObject = $this->container->make($storageString)->initOptions($options);
        if (!$storageObject instanceof SessionStorageInterface) {
            throw new SessionStorageInvalidArgument($storageString . ' is not a valid session storage object!');
        }
        return $this->container->make(SessionInterface::class)->iniSession($sessionName);
    }
}