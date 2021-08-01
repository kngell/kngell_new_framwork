<?php
declare(strict_types=1);
class ClothingController extends Controller
{
    public function __construct()
    {
    }

    // Promotions page
    public function clothingPage()
    {
        $this->view_instance->set_pageTitle('Clothing');
        $this->view_instance->set_siteTitle('Clothing');
        $this->view_instance->render('clothing' . DS . 'clothing', ['slider' => $this->getSliders()->index_clothing]);
    }

    // Product details custom
    public function detailsPage($data = [])
    {
        $id = $this->request->add_slashes(array_pop($data));
        if ($id) {
            $this->view_instance->set_siteTitle('Product Details');
            $this->view_instance->set_pageTitle('Details');
            $this->view_instance->p_details = $this->container->make(ProductsManager::class)->getDetails($id, 'p_slug');
        }
        $this->view_instance->render('clothing' . DS . 'details');
    }
}