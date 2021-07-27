<?php
declare(strict_types=1);
class OrderDetailsManager extends Model
{
    protected $_colID = 'odID';
    protected $_table = 'order_details';
    protected $_colIndex = 'od_orderID';

    //=======================================================================
    //construct
    //=======================================================================
    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
        $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table))) . 'Manager';
    }

    //=======================================================================
    //Getters & setters
    //=======================================================================
    public function getOrderDetails(int $ordID = -1) : array
    {
        $tables = ['table_join' => ['products' => ['p_title', 'p_short_descr', 'p_media', 'p_regular_price'], $this->_table => ['*']]];
        $data = ['join' => 'INNER JOIN',
            'rel' => [['pdtID', 'od_productID']],
            'where' => ['od_orderID' => ['value' => $ordID, 'tbl' => $this->_table]],
            'return_mode' => 'class'];
        $uc = $this->getAllItem($data, $tables);
        return $uc->count() > 0 ? $uc->get_results() : [];
    }

    //=======================================================================
    //Operations
    //=======================================================================
    public function saveOrderDetails(array $user_cart, $last_ordID)
    {
        if (isset($user_cart[0]) && count($user_cart[0]) > 0) {
            $cart_manager = $this->container->make(CartManager::class);
            foreach ($user_cart[0] as $cart_item) {
                if ($cart_item->c_content == 'cart') {
                    $this->od_orderID = $last_ordID;
                    $this->od_warehouseID = $cart_item->p_warehouse;
                    $this->od_productID = $cart_item->pdtID;
                    $this->od_unitID = $cart_item->p_unitID;
                    $this->od_packing_size = $cart_item->p_package_size;
                    $this->od_quantity = $cart_item->item_qty;
                    $this->od_amount = $this->money->setPrice($cart_item->p_regular_price * $cart_item->item_qty);
                    $pdt_tax = $cart_manager->getProductAndTax($cart_item->pdtID);
                    if (is_array($pdt_tax) && count($pdt_tax) > 0) {
                        $tax = 0;
                        foreach ($pdt_tax as $tax_line) {
                            if ($tax_line->p_charge_tax == 'on' && $tax_line->t_rate != null && $tax_line->catID == $cart_item->catID) {
                                $tax += $this->od_amount * $tax_line->t_rate / 100;
                            }
                        }
                        $this->od_tax_amount = (string) $this->money->setPrice($tax);
                    }
                    if (!($this->save())) {
                        return ['errors' => 'Unable to save order details informations'];
                    }
                }
            }
            $cart_manager = null;
            return true;
        }
        return false;
    }
}