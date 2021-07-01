<?php
declare(strict_types=1);
class CartManager extends Model
{
    protected string $_colID = 'cart_id';
    protected string $_table = 'cart';
    protected $_colIndex = 'user_id';
    public static $cart_template;
    public static $sub_total_template;
    public static $wishlist_template;
    public static $empty_cart_template;

    //=======================================================================
    //construct
    //=======================================================================
    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
        $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table))) . 'Manager';
        self::$cart_template = file_get_contents(FILES . 'template' . DS . 'e_commerce' . DS . 'shopping_cart' . DS . 'shpping_cart_template.php');
        self::$sub_total_template = file_get_contents(FILES . 'template' . DS . 'e_commerce' . DS . 'shopping_cart' . DS . 'cart_subtotal_template.php');
        self::$wishlist_template = file_get_contents(FILES . 'template' . DS . 'e_commerce' . DS . 'shopping_cart' . DS . 'whishlist_template.php');
        self::$empty_cart_template = file_get_contents(VIEW . 'client' . DS . 'home' . DS . 'partials' . DS . '_empty_cart_template.php');
    }

    //=======================================================================
    //Get Cart items
    //=======================================================================
    public function getUserItem($cookie = '', $id = '', $tbl = '', )
    {
        $tables = ['table_join' => [$this->_table => ['*'], 'products' => ['*'], 'product_categorie' => ['*'], 'categories' => ['categorie']]];
        $data = [
            'join' => 'INNER JOIN', 'rel' => [['item_id', 'pdtID'], ['pdtID', 'pdtID'], ['catID', 'catID']],
            'where' => ['user_id' => ['value' => $cookie, 'tbl' => $this->_table]],
            'group_by' => ['pdtID' => ['tbl' => 'products']],
            'return_mode' => 'class'
        ];
        if (!empty($id)) {
            $data['where'] = array_merge($data['where'], ['pdtID' => ['value' => $id, 'tbl' => 'products']]);
        }
        $uc = $this->getAllItem($data, $tables);
        return $uc->count() > 0 ? $uc->get_results() : [];
    }

    //=======================================================================
    //Get Single product and tax
    //=======================================================================
    public function getProductAndTax($id)
    {
        $tables = ['table_join' => ['products' => ['pdtID', 'p_regular_price', 'p_charge_tax'], 'product_categorie' => ['catID'], 'categories' => ['categorie'], 'taxe_region' => ['tr_tax_ID'], 'taxes' => ['t_rate', 't_class']]];
        $data = [
            'join' => 'LEFT JOIN',
            'rel' => [['pdtID', 'pdtID'], ['catID', 'catID'], ['catID', 'tr_catID'], ['tr_tax_ID', 'tID']],
            'where' => ['pdtID' => ['value' => $id, 'tbl' => 'products']],
            'group_by' => ['t_rate' => ['tbl' => 'taxes']],
            'return_mode' => 'class'
        ];
        $uc = $this->getAllItem($data, $tables);
        return $uc->count() > 0 ? $uc->get_results() : [];
    }

    //=======================================================================
    // Update Cart price
    //=======================================================================
    public function update_UserCartPrice($params)
    {
        if (Cookies::exists(VISITOR_COOKIE_NAME)) {
            $user_id = Cookies::get(VISITOR_COOKIE_NAME);
            $user_items = $this->getUserItem($user_id);
            $query_params = ['item_id' => $params['item_id'], 'user_id' => $user_id];
            $this->update($query_params, ['item_qty' => $params['qty']]);
            if ($user_items) {
                $user_item = current(array_filter($user_items, function ($item) use ($params) {
                    return $item->item_id == $params['item_id'];
                }));
                $old_qty = $user_item->item_qty;
                $user_item->item_qty = $params['qty'];
                $taxe_lines = $this->get_taxes([$user_item->catID]);
                $taxe_values = $this->get_taxesValues([$user_item], $taxe_lines);
            }
            $user_items = null;
            return $user_item ? [$user_item, $taxe_values, $old_qty] : null;
        }
    }

    public function get_sub_total_taxes_html($taxes = null, $temp = '')
    {
        $template_html = '';
        $total = 0;
        if ($taxes != null) {
            foreach ($taxes as $key => $value) {
                $template = $temp;
                $template = str_replace('{{title}}', $value[1], $template);
                $template = str_replace('{{tax_amount}}', strval($this->get_currency($value[0])), $template);
                $template = str_replace('{{tax-class}}', $key, $template);
                $template_html .= $template;
                $total += $value[0];
            }
        }
        return [$template_html, $total];
    }

    //=======================================================================
    // Get Cart Template
    //=======================================================================
    public function getHtmlData($item = [])
    {
        if (Cookies::exists(VISITOR_COOKIE_NAME)) {
            $user_cart = $this->getUserItem(Cookies::get(VISITOR_COOKIE_NAME));
            $cart_html = '';
            $wl_html = '';
            $price = $this->get_currency(0);
            $nb_item = 0;
            if ($user_cart && count($user_cart) > 0) {
                foreach ($user_cart as $product) {
                    if ($product->c_content == 'cart') {
                        $item_html = $this->output_shopping_template($product);
                        $cart_html .= $item_html[0];
                        $price = $price->plus($item_html[1]);
                        $nb_item++;
                    } elseif ($product->c_content == 'wishlist') {
                        $wl_html .= $this->output_shopping_template($product, self::$wishlist_template)[0];
                    }
                }
                $sub_total = self::$sub_total_template;
                $pdt_categories = array_unique(array_column(array_filter($user_cart, function ($uc) {return $uc->c_content == 'cart';}), 'catID'));
                if ($pdt_categories) {
                    $taxe_lines = $this->get_taxes($pdt_categories);
                    $taxe_values = $this->get_taxesValues($user_cart, $taxe_lines);
                    $total_taxes = $this->get_sub_total_taxes_html($taxe_values, $this->get_taxHtmlTemplate()['cart']);
                }
                $sub_total = str_replace('{{nb_items}}', strval($nb_item), $sub_total);
                $sub_total = str_replace('{{total_price}}', strval($price), $sub_total);
                $sub_total = str_replace('{{taxes_tempplate}}', isset($total_taxes) && $total_taxes[0] ? strval($total_taxes[0]) : '', $sub_total);
                $sub_total = str_replace('{{total_ttc}}', strval($price->plus(isset($total_taxes) && $total_taxes[1] ? $total_taxes[1] : 0)) ?? 0, $sub_total);
                $sub_total = str_replace('{{proccedd_token}}', FH::csrfInput('csrftoken', self::$container->load([Token::class => []])->Token->generate_token(8, 'buy-frm')), $sub_total);
            }
            if ($cart_html == '') {
                $cart_html = self::$empty_cart_template;
            }
            $user_cart = null;
            return [$nb_item ?? 0, $cart_html ?? '', $sub_total ?? '', $wl_html ?? ''];
        }
        return [];
    }

    //output template with
    public function output_shopping_template($product, $template = '')
    {
        $temp = $template != '' ? $template : self::$cart_template;
        if ($product) {
            $temp = str_replace('{{title}}', $this->htmlDecode($product->p_title), $temp);
            $temp = str_replace('{{brand}}', $product->categorie, $temp);
            $temp = str_replace('{{image}}', $product->p_media != '' ? IMG . unserialize($product->p_media)[0] : ImageManager::asset_img('products/product-80x80.jpg'), $temp);
            $temp = str_replace('{{price}}', strval($this->get_currency($product->p_regular_price * $product->item_qty)), $temp);
            $temp = str_replace('{{product_id}}', strval($product->pdtID), $temp);
            $temp = str_replace('{{qty}}', strval($product->item_qty), $temp);
            $temp = str_replace('{{del_save_token}}', FH::csrfInput('csrftoken', self::$container->load([Token::class => []])->Token->generate_token(8, 'delete-cart-item-frm' . $product->pdtID ?? 1)), $temp);
            $temp = str_replace('{{qty_token}}', FH::csrfInput('csrftoken', self::$container->load([Token::class => []])->Token->generate_token(8, 'form_qty' . $product->pdtID ?? 1)), $temp);
            return [$temp, $product->p_regular_price * $product->item_qty];
        }

        return [false, 0];
    }

    //=======================================================================
    // Add to Car
    //=======================================================================
    public function manage_user_cart($content = '')
    {
        $itemHtml = [];
        if (Cookies::exists(VISITOR_COOKIE_NAME)) {
            $this->user_id = Cookies::get(VISITOR_COOKIE_NAME);
            $cart_item = current(array_filter($this->getUserItem($this->user_id), function ($cart) {
                return $cart->item_id == $this->item_id;
            }));
            if ($cart_item) {
                $colID = $cart_item->get_colID();
                if ($content == 'save_For_Later') {
                    $cart_item->c_content = 'wishlist';
                } elseif ($content == 'add_To_Cart') {
                    $cart_item->c_content = 'cart';
                }
            }
            $this->assign($cart_item);
            $this->id = $cart_item->$colID;
            if ($this->save()) {
                $itemHtml = $this->output_shopping_template($cart_item);
            }
        }
        return $itemHtml;
    }

    //=======================================================================
    //Get Taxes
    //=======================================================================
    public function get_taxes($cat = [], $country_code = '')
    {
        $tables = ['table_join' => ['taxes' => ['*'], 'taxe_region' => ['*']]];
        $data = ['join' => 'LEFT JOIN', 'rel' => [['tID', 'tr_tax_ID']], 'where' => ['tr_catID' => ['value' => $cat, 'tbl' => 'taxe_region', 'operator' => 'IN']], 'return_mode' => 'class'];
        $uc = $this->getAllItem($data, $tables);
        return $uc->count() > 0 ? $uc->get_results() : [];
    }

    // Get taxes values
    public function get_taxesValues($user_cart = [], $taxe_lines = [])
    {
        $taxe_values = [];
        foreach ($user_cart as $product) {
            if ($product->p_charge_tax == 'on' && $product->c_content == 'cart') {
                $taxe_product = array_filter($taxe_lines, function ($taxe) use ($product) {
                    return $product->catID == $taxe->tr_catID;
                });
                if ($taxe_product) {
                    foreach ($taxe_product as $tp) {
                        if (!isset($taxe_values[$tp->t_class])) {
                            $taxe_values[$tp->t_class] = [$product->p_regular_price * $tp->t_rate * $product->item_qty / 100, $tp->t_name, $tp->t_rate];
                        } else {
                            $taxe_values[$tp->t_class][0] += $product->p_regular_price * $tp->t_rate * $product->item_qty / 100;
                        }
                    }
                }
            }
        }
        return $taxe_values;
    }

    //=======================================================================
    //Get Cart data no html
    //=======================================================================
    public function get_userCart($id = ''):array
    {
        if (Cookies::exists(VISITOR_COOKIE_NAME)) {
            $user_cart = $this->getUserItem(Cookies::get(VISITOR_COOKIE_NAME), !empty($id) ? $id : '');
            $ht = $this->get_currency(0);
            if ($user_cart) {
                foreach ($user_cart as $product) {
                    if ($product->c_content == 'cart') {
                        $product->price = $this->get_currency($product->p_regular_price * $product->item_qty);
                        $ht = $ht->plus($product->p_regular_price * $product->item_qty);
                    }
                }
                $pdt_categories = array_unique(array_column(array_filter($user_cart, function ($uc) {return $uc->c_content == 'cart';}), 'catID'));
                if ($pdt_categories) {
                    $taxe_lines = $this->get_taxes($pdt_categories);
                    $taxe_values = $this->get_taxesValues($user_cart, $taxe_lines);
                    $temps = $this->get_taxHtmlTemplate();
                    $tax_html = [];
                    foreach ($temps as $key => $temp) {
                        $tax_html[$key] = $this->get_sub_total_taxes_html($taxe_values, $temp);
                    }
                    $ttc = $ht->plus($tax_html['cart'][1]);
                }
            }
        }
        return [$user_cart, $taxe_values ?? null, [$ht ?? 0, $ttc ?? 0], $tax_html ?? [], self::$empty_cart_template];
    }

    public function get_taxHtmlTemplate()
    {
        return [
            'cart' => file_get_contents(FILES . 'template' . DS . 'e_commerce' . DS . 'shopping_cart' . DS . 'shopping_cart_taxes_template.php'),
            'checkout' => file_get_contents(FILES . 'template' . DS . 'e_commerce' . DS . 'checkout' . DS . 'checkout_tax_template.php')
        ];
    }

    //=======================================================================
    //Delete user cart
    //=======================================================================
    public function delete_cart($params = [], $id = '')
    {
        return Cookies::exists(VISITOR_COOKIE_NAME) ? $this->delete('', ['where' => ['user_id' => Cookies::get(VISITOR_COOKIE_NAME), 'item_id' => $params['item_id']]]) : false;
    }

    //=======================================================================
    //After Delete
    //=======================================================================
    public function afterDelete($params = [])
    {
        $empty_cart_template = file_get_contents(VIEW . 'client' . DS . 'home' . DS . 'partials' . DS . '_empty_cart_template.php');
        $products_taxes = $this->getProductAndTax($params['where']['item_id']);
        $product_price = 0;
        $pt = [];
        if ($products_taxes && count($products_taxes) > 0) {
            foreach ($products_taxes as $item) {
                if (!isset($pt[$item->t_class]) && $item->p_charge_tax == 'on') {
                    $pt[$item->t_class] = $item->t_rate;
                }
            }
            $product_price = $products_taxes[0]->p_regular_price;
        }
        return [$product_price, $pt == [] ? false : $pt, $empty_cart_template ?? []];
    }

    public function beforeSave($params = [])
    {
        parent::beforeSave();
        if ($params) {
            if (Cookies::exists(VISITOR_COOKIE_NAME)) {
                $user_data = AuthManager::$currentLoggedInUser; //? AuthManager::$currentLoggedInUser : $this->getDetails(Cookies::get(VISITOR_COOKIE_NAME), $this->get_colIndex());
                $this->user_id = $user_data ? $user_data->user_cookie : Cookies::get(VISITOR_COOKIE_NAME);
                $user_cart = $this->user_id ? $this->getAllbyIndex($this->user_id)->get_results() : false;
                if ($user_cart && count($user_cart) > 0) {
                    $cart = array_filter($user_cart, function ($item) {
                        return $item->item_id == $this->item_id;
                    });
                    if ($cart && count($cart) >= 1) {
                        return false;
                    }
                    return true;
                }
                return true;
            }
            $cookies = (new Token())->generate_token(36);
            $this->user_id = $cookies;
            Cookies::set(VISITOR_COOKIE_NAME, $cookies, COOKIE_EXPIRY);
        }
        return true;
    }

    public function get_successMsg($response = null, $action = '', $method = '')
    {
        if ($response['saveID']->_lastID != null) {
            return [1];
        }
        return [0];
    }
}