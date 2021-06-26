<?php
declare(strict_types=1);

defined('ROOT_DIR') or define('ROOT_DIR', realpath(dirname(__DIR__)));
require_once ROOT_DIR . '/vendor/autoload.php';

(new Container())->load([Application::class => ['appRoot' => ROOT_DIR]])->Application->run()->setSession()->setrouteHandler();