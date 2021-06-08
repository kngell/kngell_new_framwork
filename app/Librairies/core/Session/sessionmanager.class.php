<?php

declare(strict_types=1);

use Symfony\Component\Yaml\Yaml;

class SessionManager
{
    public function __construct()
    {
    }

    public static function initialize()
    {
        return (new SessionFactory())->create('generic_session_name', NativeSessionStorage::class, YamlConfig::file('session'));
    }
}