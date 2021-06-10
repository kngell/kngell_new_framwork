<?php

declare(strict_types=1);
class TestController extends Controller
{
    public function __construct($controller, $method)
    {
        parent::__construct($controller, $method);
    }

    public function indexMethod()
    {
        $container = new Container();
        $data = $container->get(UsersManager::class);
        $this->view_instance->set_pageTitle('Test');
        $this->view_instance->set_siteTitle('Test');
        $this->render('client' . DS . 'test' . DS . 'index', [dump($data)]);
    }

    protected function before()
    {
        parent::before();
    }

    protected function after()
    {
    }
}