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
            $shipping_class = $this->container->make(ShippingClassManager::class)->getDetails($shClass);
            if ($shipping_class->count() === 1) {
                $shipping_class = current($shipping_class->get_results());
                $startdate = (new DateTime())->format('Y-m-d');
                $Class = $shipping_class->delivery_lead_time; //shipping Class
                return $this->container->make(MyDateTime::class)->add_business_days($startdate, $Class, $holidays, $dateformat);
            }
        }
        return null;
    }

    public function getOrders(array $where = []) : array
    {
        $tables = [
            'table_join' => [
                'users' => ['firstName', 'lastName', 'email', 'phone'],
                $this->_table => ['*'],
                'order_details' => ['*'],
                'products' => ['p_media', 'p_short_descr', 'p_title', 'p_size', 'p_regular_price'],
                'shipping_class' => ['sh_name'],
                'company' => ['sigle', 'denomination'],
                'user_extra_data' => ['u_comment'],
            ]
        ];
        $data = array_merge([
            'join' => 'INNER JOIN',
            'rel' => [
                ['userID', 'ord_userID'],
                ['ordID', 'od_orderID'],
                ['od_productID', 'pdtID'],
                [['value' => 'ord_delivered_class', 'tbl' => 'orders'], ['value' => 'shcID', 'tbl' => 'shipping_class']],
                [['value' => 'sh_compID', 'tbl' => 'shipping_class'], ['value' => 'compID', 'tbl' => 'company']],
                [['value' => 'ord_userID', 'tbl' => 'orders'], ['value' => 'userID', 'tbl' => 'user_extra_data']]
            ],
            'return_mode' => 'class',
            'return_mode' => 'class'
        ], $where) ;
        $uc = $this->getAllItem($data, $tables);
        return $uc->count() > 0 ? $uc->get_results() : [];
    }

    public function get_userOrders()
    {
        $where = ['userID' => AuthManager::$currentLoggedInUser->userID];
        return $this->getOrders($where);
    }

    public function get_userOrdersAndDetails()
    {
        $where = ['where' => ['ord_userID' => ['value' => AuthManager::$currentLoggedInUser->userID, 'tbl' => $this->_table]]];
        return $this->getOrders($where);
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
        $orders = $this->getOrders(['group_by' => 'ordID DESC']);
        $orders = $this->getAddress($orders);
        return $orders;
    }

    public function getOrdercustomDetails(mixed $id, string $colID = ''): ?Model
    {
        $query_params = ['where' => ['ordID' => ['value' => $id, 'tbl' => $this->_table]]];
        $orders = $this->getOrders($query_params);
        if (is_array($orders) && count($orders) > 0) {
            $orderHeader = $orders[0];
            $orderHeader->ord_date = $this->getDate($orderHeader->created_at, 'd/m/y');
            $address = $this->output_addressTempplate($orderHeader);
            $orderHeader->billing_address = $address['billing'];
            $orderHeader->shipping_address = $address['shipping'];
            $orderHeader->order_details_summary = $this->output_orderDetails($orders);
            $orderHeader->order_details_total = $this->output_orderDetailsTotal($orderHeader);
            $this->_results = [$orderHeader];
            return $this;
        }
        return null;
    }

    public function output_orderDetails(array $orders = []) : string
    {
        $od_template = file_get_contents(FILES . 'template' . DS . 'admin' . DS . 'order_detailsTemplate.php');
        $item = '';
        foreach ($orders as $order) {
            $od_items = file_get_contents(FILES . 'template' . DS . 'admin' . DS . 'order_detailsTemplateItem.php');
            $od_items = str_replace('{{ProductId}}', (string)$order->od_productID ?? '', $od_items);
            $od_items = str_replace('{{productsTitle}}', $order->p_title ?? '', $od_items);
            $od_items = str_replace('{{ProductShortDescr}}', $order->p_short_descr ?? '', $od_items);
            $od_items = str_replace('{{productsSize}}', $order->p_size ?? '', $od_items);
            $od_items = str_replace('{{productUnitPrice}}', strval($this->money->getAmount($order->p_regular_price)) ?? '', $od_items);
            $od_items = str_replace('{{productQty}}', (string)$order->od_quantity ?? '', $od_items);
            $od_items = str_replace('{{total}}', $order->od_amount ?? '', $od_items);
            $item .= $od_items;
        }
        $od_template = str_replace('{{od_items}}', $item, $od_template);
        $od_items = null;
        return $od_template;
    }

    public function output_orderDetailsTotal(OrdersManager $order) : string
    {
        $od_subtotal = file_get_contents(FILES . 'template' . DS . 'admin' . DS . 'order_detailsTotalTemplate.php');
        $od_subtotal = str_replace('{{TotalHT}}', (string)$this->money->getAmount($order->ord_amountHT ?? 0) ?? '', $od_subtotal);
        $od_subtotal = str_replace('{{TotalTTC}}', (string)$this->money->getAmount($order->ord_amountTTC ?? 0) ?? '', $od_subtotal);
        $taxes = unserialize($order->ord_tax);
        $tax_line = '';
        if (count($taxes) > 0) {
            foreach ($taxes as $key => $tax) {
                $tax_temp = file_get_contents(FILES . 'template' . DS . 'admin' . DS . 'order_detailsAdminSutotalTax.php');
                $tax_temp = str_replace('{{taxline}}', $key ?? '', $tax_temp);
                $tax_temp = str_replace('{{taxpercent}}', (string)$tax[2] . '%' ?? '', $tax_temp);
                $tax_temp = str_replace('{{tax}}', (string)$this->money->getAmount($tax[0] ?? 0) ?? '', $tax_temp);
                $tax_line .= $tax_temp;
            }
        }
        $od_subtotal = str_replace('{{tax}}', $tax_line ?? '', $od_subtotal);
        return $od_subtotal;
    }

    public function output_addressTempplate(OrdersManager $order = null) : array
    {
        $orderBillingAddr = current($this->getAddress([$order]))->ord_billing_addr[0];
        $orderShippingAddr = current($this->getAddress([$order]))->ord_delivery_addr[0];
        //Billing Address
        $BillingAddrtemplate = file_get_contents(FILES . 'template' . DS . 'admin' . DS . 'billing_addressTemplate.php');
        $BillingAddrtemplate = str_replace('{{customerName}}', $order->firstName . ' ' . $order->lastName ?? '', $BillingAddrtemplate);
        $BillingAddrtemplate = str_replace('{{customerEmail}}', $order->email ?? '', $BillingAddrtemplate);
        $BillingAddrtemplate = str_replace('{{customerPhone}}', $order->phone ?? '', $BillingAddrtemplate);
        $BillingAddrtemplate = str_replace('{{customerAddress}}', $orderBillingAddr->address1 . ' ' . $orderBillingAddr->address2 ?? '', $BillingAddrtemplate);
        $BillingAddrtemplate = str_replace('{{customerCity}}', $orderBillingAddr->ville ?? '', $BillingAddrtemplate);
        $BillingAddrtemplate = str_replace('{{customerZip}}', $orderBillingAddr->zip_code ?? '', $BillingAddrtemplate);
        $BillingAddrtemplate = str_replace('{{customerCountry}}', $orderBillingAddr->get_countrie((string)$orderBillingAddr->pays)[$orderBillingAddr->pays] ?? '', $BillingAddrtemplate);

        //Shipping Address
        $shippingAddrtemplate = file_get_contents(FILES . 'template' . DS . 'admin' . DS . 'shipping_addressTemplate.php');
        $shippingAddrtemplate = str_replace('{{customerName}}', $order->firstName . ' ' . $order->lastName ?? '', $shippingAddrtemplate);
        $shippingAddrtemplate = str_replace('{{customerEmail}}', $order->email ?? '', $shippingAddrtemplate);
        $shippingAddrtemplate = str_replace('{{customerPhone}}', $order->phone ?? '', $shippingAddrtemplate);
        $shippingAddrtemplate = str_replace('{{customerAddress}}', $orderShippingAddr->address1 . ' ' . $orderShippingAddr->address2 ?? '', $shippingAddrtemplate);
        $shippingAddrtemplate = str_replace('{{customerCity}}', $orderShippingAddr->ville ?? '', $shippingAddrtemplate);
        $shippingAddrtemplate = str_replace('{{customerZip}}', $orderShippingAddr->zip_code ?? '', $shippingAddrtemplate);
        $shippingAddrtemplate = str_replace('{{customerCountry}}', $orderShippingAddr->get_countrie((string)$orderShippingAddr->pays)[$orderShippingAddr->pays] ?? '', $shippingAddrtemplate);

        return ['billing' => $BillingAddrtemplate, 'shipping' => $shippingAddrtemplate];
    }

    public function getAddress(array $orders = [])
    {
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

    private function getOrderStatus(int $od, string $date = '') : ?string
    {
        if (!empty($od)) {
            switch ($od) {
                case 1:
                    return 'Commande livrée';
                break;
                case 2:
                    return 'Commande en attente de paiement';
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
        $template = str_replace('{{ord_ttc}}', (string) $this->money->getAmount($ord_headers->ord_amountTTC) ?? '', $template);
        $template = str_replace('{{ord_userFullName}}', $ord_headers->firstName . ' ' . $ord_headers->lastName, $template);
        $template = str_replace('{{ord_number}}', $ord_headers->ord_number ?? '', $template);
        $template = str_replace('{{ord_deliveryDate}}', $this->getDate($ord_headers->ord_delivery_date) ?? '', $template);
        $template = str_replace('{{ord_status}}', $this->getOrderStatus($ord_headers->ord_status ?? -1) ?? '', $template);
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
    public function placeOrder(array $params = [], array $user_cart = [])
    {
        //order indentiers
        $this->ord_number = $this->get_unique('ord_number', '#', '-' . random_int(100000, 999999), 6);
        $this->ord_userID = AuthManager::$currentLoggedInUser->userID;
        $this->ord_pmt_mode = $params['payment_mode'];
        $this->ord_pmt_ID = $params['pmt_infos']->id;
        $this->ord_delivery_address = $params['user_session']['ship_address']['id'];
        $this->ord_invoice_address = $params['user_session']['bill_address']['id'];
        //get_user cart data;
        if (!empty($user_cart)) {
            $this->ord_amountHT = $this->money->setPrice($user_cart[2][0]);
            $this->ord_amountTTC = $this->money->setPrice($params['user_session']['ttc']);
            $this->ord_tax = isset($user_cart[1]) ? serialize($user_cart[1]) : '';
            $item_qty = 0;
            foreach ($user_cart[0] as $cart_item) {
                if ($cart_item->c_content == 'cart') {
                    $item_qty += $cart_item->item_qty;
                }
            }
            $this->ord_qty = $item_qty;
        }
        //Delivery Lead Time calc with shipping class
        $this->ord_delivery_date = $this->get_deliveredDate((string)$params['user_session']['shipping']['id']);
        $this->ord_delivered_class = $params['user_session']['shipping']['id'];
        $this->ord_pmt_status = 'pending';
        if ($r = $this->save()) {
            if ($rd = $this->container->make(OrderDetailsManager::class)->saveOrderDetails($user_cart, $r->get_lastID())) {
                $this->container->make(GroupsManager::class)->setUserGroup('Customer', $this->ord_userID);
                return $r;
            }
        }
        return false;
    }

    public function confirmOrderPayment(array $pmt_infos = [])
    {
        $session = GlobalsManager::get('global_session');
        $order_id = $session->get('order_id');
        if ($order_id) {
            $order = $this->getDetails($order_id);
            if ($order->count() === 1) {
                $order = current($order->get_results());
                if ($pmt_infos['paymentIntent']['status'] == 'succeeded') {
                    $order->ord_pmt_status = 'success';
                    $order->id = $order_id;
                    if (!$order->save()) {
                        $session->delete('order_id');
                        $session = null;
                        return false;
                    }
                }
            }
        }
        $session->delete('order_id');
        $session = null;
        return true;
    }

    public function get_fieldName(string $table = '') : string
    {
        switch ($table) {
            case 'orders':
                return 'ord_status';
                break;

            default:
                // code...
                break;
        }
    }
}