<?php
declare(strict_types=1);

defined('ROOT_DIR') or define('ROOT_DIR', realpath(dirname(__DIR__)));
require_once ROOT_DIR . '/vendor/autoload.php';

$app = new Application(ROOT_DIR);
$app->run()->setSession()->setrouteHandler();