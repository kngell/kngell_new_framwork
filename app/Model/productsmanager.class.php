<?php
declare(strict_types=1);
class ProductsManager extends Model
{
    protected string $_colID = 'pdtID';
    protected string $_table = 'products';
    protected $_colContent = '';
    protected array $checkboxes = ['p_charge_tax', 'p_track_qty', 'p_continious_sell'];
    protected array  $select2_field = ['p_company', 'p_warehouse', 'p_shipping_class', 'p_unitID'];

    /**
     * Main Contructor
     * ==========================================================================================================
     */
    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
    }

    /**
     * Get Success Message
     * ==========================================================================================================
     * @param string $method
     * @param array $data
     * @return void
     */
    public function get_successMessage($method = '', $data = [])
    {
        switch ($method) {
            case 'update':
                return 'Produit mis a jour avec success!';
                break;
            case 'delete':
                return 'Produit Supprimé!';
                break;
            default:
                return 'Produit créee avec success!';
                break;
        }
    }

    /**
     * Before Save
     * ==========================================================================================================
     * @param array $params
     * @return void
     */
    public function beforeSave($params = []) : mixed
    {
        parent::beforeSave($params);
        // Manage prices
        $this->p_regular_price = $this->money->setPrice($this->p_regular_price);
        $this->p_compare_price = $this->money->setPrice($this->p_compare_price);
        $this->p_cost_per_item = $this->money->setPrice($this->p_cost_per_item);
        $this->p_shipping_class = (int) $this->get_defaultShippingClass()['shcID'];
        // User Salt
        $this->user_salt = AuthManager::$currentLoggedInUser->salt;
        // product slag
        $slug = $this->str_to_url($this->p_title);
        if (!$this->p_slug || empty($this->p_lug) || !isset($this->p_slug) || $this->p_slug != $slug) {
            while ($this->getDetails($slug, 'p_slug')->count() > 0) :
                    $slug = $this->str_to_url($slug . '-' . rand(0, 99999));
            endwhile;
            $this->p_slug = $slug;
        }
        $slug = null;
        return true;
    }

    /**
     * After Save
     * ==========================================================================================================
     * @param array $params
     * @return void
     */
    public function afterSave($params = [])
    {
        // parent::beforeSave();
        if ($params) {
            $categories = isset($params['categories']) && $params['categories'] != '' ? json_decode($this->htmlDecode($params['categories']), true) : [];
            $colID = $this->get_colID();
            $lastID = $this->$colID == null ? $params['saveID']->get_lastID() : $this->$colID;
            if ($categories) {
                $product_categorie = $this->container->make(ProductCategorieManager::class)->getAllbyIndex((string)$lastID, ['return_mode' => 'class']);
                if ($product_categorie->count() > 0) {
                    foreach ($product_categorie->get_results() as $pc) {
                        if (!$pc->delete()) {
                            break;
                            return false;
                        }
                    }
                }
                foreach ($categories as $catID) {
                    $product_categorie->catID = $catID;
                    $product_categorie->pdtID = $this->pdtID == null ? $lastID : $this->pdtID;
                    if (!$product_categorie->save()) {
                        break;
                        $product_categorie = null;
                        return false;
                    }
                }
                $product_categorie = null;
            }
        }
        return $params['saveID'];
    }

    /**
     * Get Selected Options
     * ==========================================================================================================
     * @param string $table
     * @return mixed
     */
    public function get_selectedOptions(Object $m = null)
    {
        $options = $this->get_options_data($m->get_tableName());
        $response = [];
        if ($options) {
            $colTitle = array_pop($options);
            $colID = array_pop($options);
            if (count($options) > 0) {
                foreach ($options as $item) {
                    $response[$item->$colID] = $this->htmlDecode($item->$colTitle);
                }
            }
        }
        $options = null;
        return $response ? $response : [];
    }

    /**
     * Get Options Data
     * ==========================================================================================================
     * @param string $table
     * @return array
     */
    public function get_options_data(string $table) : array
    {
        $r = [];
        switch ($table) {
            case 'categories':
                $tables = ['table_join' => ['categories' => ['*'], 'product_categorie' => ['pdtID', 'catID']]];
                $data = ['join' => 'INNER JOIN',
                    'rel' => [['catID', 'catID']],
                    'where' => ['pdtID' => ['value' => $this->pdtID, 'tbl' => 'product_categorie']],
                    'group_by' => 'categorie',
                    'return_mode' => 'class'];
                $r = $this->container->make(ProductCategorieManager::class)->getAllItem($data, $tables)->get_results();
                $r['colID'] = 'catID';
                $r['colTitle'] = 'categorie';
            break;
            case 'warehouse':
                $r = $this->container->make(WarehouseManager::class)->getAllItem(['where' => ['whID' => $this->p_warehouse], 'return_mode' => 'class'])->get_results();
                $r['colID'] = 'whID';
                $r['colTitle'] = 'wh_name';
            break;
            case 'company':
                $r = $this->container->make(CompanyManager::class)->getAllItem(['where' => ['compID' => $this->p_company], 'return_mode' => 'class'])->get_results();
                $r['colID'] = 'compID';
                $r['colTitle'] = 'sigle';
            break;
            case 'shipping_class':
                $r = $this->container->make(ShippingClassManager::class)->getAllItem(['where' => ['shcID' => $this->p_shipping_class], 'return_mode' => 'class'])->get_results();
                $r['colID'] = 'shcID';
                $r['colTitle'] = 'sh_name';
            break;
            case 'units':
                $r = $this->container->make(UnitsManager::class)->getAllItem(['where' => ['unID' => $this->p_unitID], 'return_mode' => 'class'])->get_results();
                $r['colID'] = 'unID';
                $r['colTitle'] = 'unit';
            break;

            default:
                // code...
            break;
        }
        return $r;
    }

    /**
     * Get Product
     * ==========================================================================================================
     * @return void
     */
    public function get_Products(mixed $brand = 2) : array
    {
        $tables = [
            'table_join' => [
                'products' => ['*'],
                'product_categorie' => ['pdtID AS pcatID', 'catID AS pc_catID'],
                'categories' => ['categorie'],
                'brand' => ['br_name']
            ]
        ];
        $where['where'] = ['brID' => ['value' => $brand, 'tbl' => 'categories']];
        if (is_array($brand)) {
            $where = [];
        }
        $data = [
            'join' => 'LEFT JOIN',
            'rel' => [['pdtID', 'pdtID'], ['catID', 'catID'], ['brID', 'brID']],
            'group_by' => ['pdtID DESC' => ['tbl' => 'product_categorie']],
            'return_mode' => 'class'
        ];
        if (!empty($where)) {
            $data = array_merge($where, $data);
        }
        $pdt = $this->container->make(ProductCategorieManager::class)->getAllItem($data, $tables);
        return $pdt->count() > 0 ? $pdt->get_results() : false;
    }

    /**
     * Get Field Name
     * ==========================================================================================================
     * @param string $table
     * @return string
     */
    public function get_fieldName(string $table = '') : string
    {
        switch ($table) {
                case 'categories':
                    return 'categorie';
                break;
                case 'warehouse':
                    return 'p_warehouse';
                break;
                case 'shipping_class':
                    return 'p_shipping_class';
                break;
                case 'company':
                    return 'p_company';
                break;
                case 'units':
                    return 'p_unitID';
                break;
                default:
                break;
            }
    }

    /**
     * Sanitize url
     * ==========================================================================================================
     * @param string $url
     * @return void
     */
    public function str_to_url(string $url)
    {
        $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
        $url = trim($url, '-');
        $url = iconv('utf-8', 'us-ascii//TRANSLIT', $url);
        $url = strtolower($url);
        $url = preg_replace('~[^-a-z0-9_]+~', '', $url);
        return $url;
    }
}