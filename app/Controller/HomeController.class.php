<?php

declare(strict_types=1);
class HomeController extends Controller
{
    public function __construct($controller, $method)
    {
        parent::__construct($controller, $method);
        //Global Assets
        if ($this->view_instance != null) {
            // $this->view_instance->set_siteTitle("K'nGELL Ingénierie Logistique");
            // //Ecommerce products
            // $this->view_instance->products = ($this->get_model('ProductsManager', 'products')['products'])->get_Products();
            // $this->view_instance->user_cart = ($this->get_model('CartManager', 'cart')['cart'])->get_userCart() ?? [];
            // $this->view_instance->search_box = file_get_contents(FILES . 'template' . DS . 'base' . DS . 'search_box.php');
        }
    }

    public function indexMethod()
    {
        $this->view_instance->set_pageTitle('Home');
        $this->view_instance->set_siteTitle('Home');
        $this->render('client' . DS . 'home' . DS . 'index', []);
    }

    protected function before()
    {
        parent::before();
    }

    protected function after()
    {
    }
}