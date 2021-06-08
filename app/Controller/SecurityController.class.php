<?php

declare(strict_types=1);
class SecurityController extends BaseController
{
    public function __construct($routesParams)
    {
        parent::__construct($routesParams);
    }

    public function login()
    {
        echo 'This is Security Controller';
    }
}