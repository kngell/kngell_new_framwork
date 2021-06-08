<?php

declare(strict_types=1);
class UsersController extends BaseController
{
    public function __construct($routesParams)
    {
        parent::__construct($routesParams);
    }

    public function indexMethod()
    {
        echo 'Admin namspace ' . $this->routeParams['controller'];
    }

    public function editMethod()
    {
        echo 'This is edit method ' . $this->routeParams['id'];
        // $user = new UsersManager();
        // dump($user->getRepository()->findObjectBy(['userID' => $this->routeParams['id']]));
    }

    protected function before()
    {
        echo 'this is before adding method <br>';
    }

    protected function after()
    {
        echo '<br>this is after adding method <br>';
    }
}