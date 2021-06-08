<?php

defined('ROOT_DIR') or define('ROOT_DIR', realpath(dirname(__FILE__)));
$autoload = ROOT_DIR . '/vendor/autoload.php';
if (is_file($autoload)) {
    require_once $autoload;
}
$container = new Container();
$user = $container->get(User::class);
$user->UserModel()->set('AKONO');
echo $user->UserModel()->get();
dd($container);
$app = new Application(ROOT_DIR);
$app->run()->setSession()->setrouteHandler();
// $router = new Rooter();
// $router->add('', ['controller' => 'Home', 'method' => 'index']);
// dump($router->getRoutes());