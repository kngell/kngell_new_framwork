<?php

declare(strict_types=1);
class AuthMiddleWare extends BaseMiddleWare
{
    protected Container $container;
    public array $actions = [];

    public function __construct()
    {
    }

    public function init($actions)
    {
        $this->actions = $actions;
    }

    public function execute()
    {
        if (Application::isGuest()) {
            if (empty($this->actions) || in_array($this->container->controller->get_method(), $this->actions)) {
                throw new ForbidenException();
            }
        }
    }
}