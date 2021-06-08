<?php

declare(strict_types=1);
class HomeController extends BaseController
{
    public function __construct($routesParams)
    {
        parent::__construct($routesParams);
    }

    public function indexMethod()
    {
        $user = new UsersManager();
        $args = YamlConfig::file('controller')['user'];
        $repository = $user->getRepository()->findWithSearchAndPagin((new RequestHandler())->handler(), $args);
        $table = (new Datatable())->create(UsersColumns::class, $repository, $args)->setAttr(['table_id' => 'myid', 'table_class' => ['rounded-circle', 'table-row']])->table();
        $this->render('client' . DS . 'home' . DS . 'index.html.twig', ['table' => $table, 'pagination' => (new Datatable())->create(UsersColumns::class, $repository, $args)->pagination()]);
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