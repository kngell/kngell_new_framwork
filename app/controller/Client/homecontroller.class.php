<?php
declare(strict_types=1);
class HomeController extends Controller
{
    public function __construct(string $controller, string $method)
    {
        parent::__construct($controller, $method);
    }

    //page index

    public function indexPage($data = [])
    {
        $this->view_instance->set_pageTitle('Home');
        $this->view_instance->set_siteTitle('Home');
        $this->view_instance->render('home' . DS . 'index');
    }

    //page product
    public function productPage($data = [])
    {
        $id = $this->request->add_slashes(array_pop($data));
        if ($id) {
            $this->view_instance->set_pageTitle('Product');
            $this->view_instance->set_siteTitle('Product');
            $this->view_instance->p_details = $this->model_instance['products']->getDetails($id, 'p_slug');
        }
        $this->view_instance->render('home' . DS . 'product' . DS . 'product');
    }

    // Product details custom
    public function detailsPage($data = [])
    {
        // $id = $this->request->add_slashes(array_pop($data));

        $this->view_instance->set_pageTitle('Details');
        $this->view_instance->set_siteTitle('Details');
        // $this->view_instance->p_details = $this->model_instance['products']->getDetails($id, 'p_slug');
        $this->view_instance->render('home' . DS . 'product' . DS . 'details');
    }

    //page cart
    public function cartPage($data = [])
    {
        // $this->view_instance->cart_product_list = file_get_contents(FILES . 'template' . DS . 'e_commerce' . DS . 'shopping_cart' . DS . '_php_shpping_cart_template.php');
        $this->view_instance->set_pageTitle('Cart');
        $this->view_instance->set_siteTitle('Cart');
        $this->view_instance->render('home' . DS . 'cart' . DS . 'cart');
    }

    // Promotions page
    public function promotionsPage()
    {
        $this->view_instance->set_pageTitle('Promotions');
        $this->view_instance->set_siteTitle('Promotions');
        $this->view_instance->render('home' . DS . 'promotions' . DS . 'promotions');
    }

    // Boutique page
    public function boutiquePage()
    {
        $this->view_instance->set_pageTitle('Boutique');
        $this->view_instance->set_siteTitle('Boutique');
        $this->view_instance->render('home' . DS . 'boutique' . DS . 'boutique');
    }

    //sitemap
    public function sitemapPage()
    {
        $this->view_instance->set_pageTitle('Sitemap');
        $this->view_instance->render('home' . DS . 'sitemap' . DS . 'sitemap');
    }

    protected function before()
    {
        parent::before();
    }

    protected function after()
    {
    }
}