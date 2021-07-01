<?php
declare(strict_types=1);

class OrdersManager extends Model
{
    protected $_colID = 'ordID';
    protected $_table = 'orders';
    protected $_colIndex = 'userID';
    protected $_colContent = '';

    //=======================================================================
    //construct
    //=======================================================================
    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
        $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table))) . 'Manager';
    }

    /**
     * Get Delivered Date
     * ========================================================================================
     * @param string $shClass
     * @param array $holidays
     * @param string $dateformat
     * @return string|null
     */
    public function get_deliveredDate(string $shClass = null, array $holidays = [], string $dateformat = 'Y-m-d H:i:s') : ?string
    {
        if ($shClass != null) {
            $shipping_class = self::$container->load([ShippingClassManager::class => []])->ShippingClass->getDetails($shClass);
            if ($shipping_class->count() === 1) {
                $shipping_class = current($shipping_class->get_results());
                $startdate = (new DateTime())->format('Y-m-d');
                $Class = $shipping_class->delivery_lead_time; //shipping Class
                return self::$container->load([MyDateTime::class => []])->MyDateTime->add_business_days($startdate, $Class, $holidays, $dateformat);
            }
        }
        return null;
    }

    public function get_userOrders()
    {
        $tables = [
            'table_join' => [
                'users' => ['firstName', 'lastName'],
                $this->_table => ['*'],
            ]
        ];
        $data = [
            'join' => 'INNER JOIN',
            'rel' => [['userID', 'ord_userID']],
            'where' => ['userID' => AuthManager::$currentLoggedInUser->userID],
            'return_mode' => 'class'
        ];
        $uc = $this->getAllItem($data, $tables);
        return $uc->count() > 0 ? $uc->get_results() : [];
    }

    public function get_userOrdersAndDetails()
    {
        $tables = [
            'table_join' => [
                'users' => ['firstName', 'lastName'],
                $this->_table => ['*'],
                'order_details' => ['*'],
                'products' => ['*'],
            ]
        ];
        $data = [
            'join' => 'INNER JOIN',
            'rel' => [['userID', 'ord_userID'], ['ordID', 'od_orderID'], ['od_productID', 'pdtID']],
            'where' => ['ord_userID' => ['value' => AuthManager::$currentLoggedInUser->userID, 'tbl' => $this->_table]],
            'return_mode' => 'class'
        ];
        $uc = $this->getAllItem($data, $tables);
        return $uc->count() > 0 ? $uc->get_results() : [];
    }

    public function get_ordersAddress(array $orders, string $rel = '')
    {
        //get Billing Adresses
        $tables = [
            'table_join' => [
                $this->_table => ['ord_number'],
                'address_book' => ['*'],
            ]
        ];
        $data = [
            'join' => 'INNER JOIN',
            'rel' => [[$rel, 'abID']],
            'where' => ['ord_number' => ['value' => $orders, 'tbl' => $this->_table, 'operator' => 'IN']],
            'return_mode' => 'class'
        ];
        $uc = $this->getAllItem($data, $tables);
        return $uc->count() > 0 ? $uc->get_results() : [];
    }

    public function getAll(array $params = []) : array
    {
        $orders = $this->get_userOrders();
        if (count($orders) > 0) {
            $ordersIIds = array_unique(array_column($orders, 'ord_number'));
            $billing_add = $this->get_ordersAddress($ordersIIds, 'ord_invoice_address');
            $delivery_addr = $this->get_ordersAddress($ordersIIds, 'ord_delivery_address');
            foreach ($orders as $order) {
                if (count($billing_add) > 0) {
                    $order->ord_billing_addr = array_filter($billing_add, function ($addr) use ($order) {
                        return $order->ord_number == $addr->ord_number && $order->ord_invoice_address == $addr->abID;
                    });
                }
                if (count($delivery_addr) > 0) {
                    $order->ord_delivery_addr = array_filter($delivery_addr, function ($addr) use ($order) {
                        return $order->ord_number == $addr->ord_number && $order->ord_delivery_address == $addr->abID;
                    });
                }
            }
        }
        return $orders;
    }

    /**
     * Get Order Template
     * ========================================================================================
     * @return void
     */
    public function getHtmlData($item = [])
    {
        $template = '';
        $orders = $this->get_userOrdersAndDetails();
        if (count($orders) > 0) {
            $ordersIIds = array_unique(array_column($orders, 'ord_number'));
            //$billing_address = $this->get_ordersAddress($ordersIIds, 'ord_invoice_address');
            foreach ($ordersIIds as $ordersIId) {
                $template .= $this->output_userOrders($ordersIId, $orders);
            }
        }
        return [$template];
    }

    private function getOrderStatus(string $od, string $date = '') : ?string
    {
        if (!empty($od)) {
            switch ($od) {
                case 'en cours':
                    return 'Colis en cours de livraison';
                break;
                default:
                return 'colis livré le ' . $date;
                break;
            }
        }
    }

    public function output_userOrders(string $orderID = '', array $orders = []) : ?string
    {
        $tp = '';
        $actual_ord = array_values(array_filter($orders, function ($order) use ($orderID) {
            return $order->ord_number == $orderID;
        }));
        $ord_headers = $actual_ord[0];
        $template = file_get_contents(FILES . 'template' . DS . 'e_commerce' . DS . 'account' . DS . 'commandesTemplate.php');
        $template = str_replace('{{ord_date}}', $this->getDate($ord_headers->created_at) ?? '', $template);
        $template = str_replace('{{ord_ttc}}', (string) $this->get_currency($ord_headers->ord_amountTTC) ?? '', $template);
        $template = str_replace('{{ord_userFullName}}', $ord_headers->firstName . ' ' . $ord_headers->lastName, $template);
        $template = str_replace('{{ord_number}}', $ord_headers->ord_number ?? '', $template);
        $template = str_replace('{{ord_deliveryDate}}', $this->getDate($ord_headers->ord_delivery_date) ?? '', $template);
        $template = str_replace('{{ord_status}}', $this->getOrderStatus($ord_headers->ord_status ?? '') ?? '', $template);
        foreach ($actual_ord as $order) {
            $temp = file_get_contents(FILES . 'template' . DS . 'e_commerce' . DS . 'account' . DS . 'ordersItemsInfosTemplate.php');
            $temp = str_replace('{{ord_itemImg}}', ImageManager::asset_img(!empty(unserialize($order->p_media)[0]) ? unserialize($order->p_media)[0] : 'products' . DS . 'product-80x80.jpg'), $temp);
            $temp = str_replace('{{ord_itemDescr}}', $this->htmlDecode($order->p_short_descr ?? '') ?? '', $temp);
            $temp = str_replace('{{ord_itemtitle}}', strtoupper($this->htmlDecode($order->p_title) ?? ''), $temp);
            $tp .= $temp;
        }
        $template = str_replace('{{ord_itemInfos}}', $tp, $template);
        return $template;
    }

    /**
     * Place Orders
     * ========================================================================================
     * @param array $params
     * @return void
     */
    public function placeOrder(array $params = [])
    {
        //order indentiers
        $this->ord_number = $this->get_unique('ord_number', '#', '-' . random_int(100000, 999999), 6);
        $this->ord_userID = AuthManager::$currentLoggedInUser->userID;
        $this->ord_pmt_mode = $params['payment_mode'];
        $this->ord_pmt_ID = $params['pmt_infos']->{$params['pmt_infos']->get_colID()};
        //get address data
        $delivery_address = $params['users_data']['save_address']['saveID'];
        $this->ord_delivery_address = $delivery_address->abID;
        if ($params['billing_addr_mode'] == 2) {
            $billing_address = $params['billing_addr']['save_addr']['saveID'];
            $this->ord_invoice_address = $billing_address->get_lastID();
            $this->ord_invoice_address_tbl = $billing_address->tbl;
        } else {
            $this->ord_invoice_address = $delivery_address->abID;
            $this->ord_invoice_address_tbl = $delivery_address->tbl;
        }
        //get_user cart
        $order_cart = self::$container->load([CartManager::class => []])->Cart->get_userCart();
        $this->ord_amountHT = (string) $this->get_currency($order_cart[2][0]);
        $this->ord_amountTTC = (string) $this->get_currency($order_cart[2][1]);
        $this->ord_tax = isset($order_cart[1]) ? serialize($order_cart[1]) : '';
        $item_qty = 0;
        foreach ($order_cart[0] as $cart_item) {
            if ($cart_item->c_content == 'cart') {
                $item_qty += $cart_item->item_qty;
            }
        }
        $this->ord_qty = $item_qty;
        //Delivery Lead Time calc with shipping class
        $this->ord_delivery_date = $this->get_deliveredDate($params['shipping']);
        $this->ord_delivered_class = $params['shipping'];
        if ($r = $this->save()) {
            $rd = self::$container->load([OrderDetailsManager::class => []])->OrderDetails->saveOrderDetails($order_cart, $r['saveID']->get_lastID());
            return $r;
        }
        return false;
    }
}