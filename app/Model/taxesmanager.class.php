<?php
declare(strict_types=1);
class TaxesManager extends Model
{
    protected $_colID = 'tID';
    protected $_table = 'taxes';
    protected $_colTitle = 't_name';

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
    public function getAll(array $params) : array
    {
        $tables = ['table_join' => ['taxes' => ['*'], 'taxe_region' => ['*'], 'categories' => ['*']]];
        $data = ['join' => 'LEFT JOIN', 'rel' => [['tID', 'tr_tax_ID'], ['tr_catID', 'catID']], 'return_mode' => 'class', 'class' => get_class($this)];
        $data = $this->set_deleted_Params($data);
        $results = $this->repository->findBy([], [], [], array_merge($data, $tables));
        if ($results->count() > 0) {
            $results = $results->get_results();
            $categories = $this->get_categories_lists($results);
            $new_results = [];
            if (count($categories) > 0) {
                foreach ($results as $R) {
                    if (!array_key_exists($R->tID, $new_results)) {
                        if (array_key_exists($R->tID, $categories)) {
                            $R->categorie = $categories[$R->tID];
                        }
                        $new_results[$R->tID] = $R;
                    }
                }
            }
        }
        return  $new_results;
    }

    /**
     * Get list of categories with when duplicates objects exist in array of objects
     *
     * @param array $results
     * @return array
     */
    public function get_categories_lists(array $results) : array
    {
        $all_keys = array_unique(array_column($results, 'tID'));
        $categories = [];
        foreach ($all_keys as $key) {
            $same_tax = array_filter($results, function ($result) use ($key) {
                return $key == $result->tID;
            });
            $categories[$key] = '(' . implode(' | ', array_column($same_tax, 'categorie')) . ')';
        }
        return $categories;
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
                return 'Taxe mise a jour avec success!';
                break;
            case 'delete':
                return 'Taxe Supprimé!';
                break;
            default:
                return 'Taxe créee avec success!';
                break;
        }
    }

    public function afterSave($params = [])
    {
        $error = false;
        if (isset($params['categorieID'])) {
            $select2_data = json_decode($this->htmlDecode($params['categorieID']), true);
            $colID = $this->get_colID();
            if (json_last_error() === JSON_ERROR_NONE) {
                $taxes_region = $this->container->make(TaxeRegionManager::class)->getAllItem(['where' => ['tr_tax_ID' => $params[$colID]], 'return_mode' => 'class']);
                if ($taxes_region->count() >= 1) {
                    foreach ($taxes_region->get_results() as $tr) {
                        if (!$tr->delete()) {
                            $error = true;
                            break;
                        }
                    }
                }
                foreach ($select2_data as $option) {
                    $taxes_region->tr_catID = $option['id'];
                    $taxes_region->tr_tax_ID = $this->$colID;
                    if (!$taxes_region->save()) {
                        $error = true;
                        break;
                    }
                }
            }
        }
        return !$error;
    }

    public function get_fieldName(string $table = '')
    {
        switch ($table) {
            case 'categories':
                return 'categorieID';
                break;

            default:
                return 'categorie';
                break;
        }
    }

    /**
     * Get selected options for taxes
     *
     * @param ModelInterface $m
     * @return array|null
     */
    public function get_selectedOptions(Object $m = null) : ?array
    {
        $tables = ['table_join' => ['categories' => ['categorie'], 'taxe_region' => ['tr_tax_ID', 'tr_catID']]];
        $data = ['join' => 'INNER JOIN',
            'rel' => [['catID', 'tr_catID']],
            'where' => ['tr_tax_ID' => $this->tID],
            'return_mode' => 'class'
        ];
        $taxe_region = $this->container->make(TaxeRegionManager::class)->getAllItem($data, $tables);
        $response = [];
        if ($taxe_region->count() >= 1) {
            foreach ($taxe_region->get_results() as $tr) {
                $response[$tr->tr_catID] = $tr->categorie;
            }
        }
        $taxe_region = null;
        return $response ? $response : [];
    }
}