<?php
declare(strict_types=1);
class CartController extends Controller
{
    public function __construct(string $controller, string $method)
    {
        parent::__construct($controller, $method);
    }

    //=======================================================================
    //PHP cart operations
    //=======================================================================
    public function display_cartPage()
    {
        $cart = $this->container->make(CartManager::class)->getHtmlData();
    }
}