<?php

declare(strict_types=1);
use Brick\Money\Money;
use Brick\Money\Context\AutoContext;
use Brick\Math\RoundingMode;

class Model extends AbstractModel
{
    protected Object $repository;
    protected static ContainerInterface $container;
    protected $validates = true;
    protected $_results;
    protected $_count;
    protected $_modelName;
    protected $_softDelete = false;
    protected $_deleted_item = false;
    protected $validationErr = [];
    protected $_lasID;

    /**
     * Main Constructor
     * =======================================================================================================
     * @param string $tableSchema
     * @param string $tableSchemaID
     */
    public function __construct(string $tableSchema, string $tableSchemaID)
    {
        $this->throwException($tableSchema, $tableSchemaID);
        $this->createRepository($tableSchema, $tableSchemaID);
    }

    /**
     * Get Data Repository method
     * =======================================================================================================
     * @return DataRepositoryInterface
     */
    public function getRepository() : DataRepository
    {
        return $this->repository;
    }

    /**
     * Throw an exception
     * ========================================================================================================
     * @return void
     */
    private function throwException(string $tableSchema, string $tableSchemaID): void
    {
        if (empty($tableSchema) || empty($tableSchemaID)) {
            throw new BaseInvalidArgumentException('Your repository is missing the required constants. Please add the TABLESCHEMA and TABLESCHEMAID constants to your repository.');
        }
    }

    /**
     * Create the model repositories
     * =========================================================================================================
     * @param string $tableSchema
     * @param string $tableSchemaID
     * @return void
     */
    public function createRepository(string $tableSchema, string $tableSchemaID): void
    {
        $factory = self::$container->load([DataRepositoryFactory::class => ['crudIdentifier' => 'baseModel', 'tableSchema' => $tableSchema, 'tableSchemaID' => $tableSchemaID]])->DataRepositoryFactory;
        $this->repository = $factory->create(DataRepository::class);
    }

    /**
     * Get All items
     * =========================================================================================================
     * @param array $data
     * @param array $params
     * @param array $tables
     * @return self
     */
    public function getAllItem(array $data = [], array $tables = [], array $params = []) : ?self
    {
        $data = $this->set_deleted_Params($data);
        if (isset($data['return_mode']) && $data['return_mode'] == 'class' && !isset($data['class'])) {
            $data = array_merge($data, ['class' => get_class($this)]);
        }
        $results = $this->repository->findBy([], [], $params, array_merge($data, $tables));
        $this->_results = $results != -1 ? $results->get_results() : null;
        $this->_count = $results != -1 ? $results->count() : 0;
        $results = null;
        return $this;
    }

    /**
     * Get Html Decode texte
     * =========================================================================================================
     * @param string $str
     * @return string
     */
    public function htmlDecode(string $str) : string
    {
        return !empty($str) ? htmlspecialchars_decode(html_entity_decode($str), ENT_QUOTES) : false;
    }

    /**
     * Get Detail
     * =========================================================================================================
     * @param mixed $id
     * @param string $colID
     * @return self|null
     */
    public function getDetails(mixed $id, string $colID = '') : ?self
    {
        $data_query = ['where' => [$colID != '' ? $colID : $this->get_colID() => $id], 'return_mode' => 'class'];
        return $this->findFirst($data_query);
    }

    /**
     * Get By Index
     * =========================================================================================================
     * @param string $index_value
     * @param array $params
     * @param array $tables
     * @return self|null
     */
    public function getAllbyIndex(string $index_value, array $params = [], array $tables = []) :?self
    {
        $data = array_merge(['where' => [$this->get_colIndex() => $index_value]], ['return_mode' => 'class'], ['class' => get_class($this)], $tables);
        $results = $this->repository->findBy([], [], [], $data);
        $this->_results = $results != -1 ? $results->get_results() : null;
        $this->_count = $results != -1 ? $results->count() : 0;
        $results = null;
        return $this;
    }

    /**
     * Save Data insert or update
     * =========================================================================================================
     * @param array $params
     * @return void
     */
    public function save(array $params = [])
    {
        if ($data = $this->beforeSave($params)) {
            $fields = H::getObjectProperties($this);
            if (property_exists($this, 'id') && $this->id != '') {
                $fields = $this->beforeSaveUpadate($fields);
                $save = $this->update([(!isset($params['colID'])) ? $this->get_colID() : $params['colID'] => $this->id], $fields);
            } else {
                $fields = $this->beforeSaveInsert($fields);
                $save = $this->insert($fields);
            }
            if ($save->count() > 0) {
                $params['saveID'] = $save ?? '';
                return $this->afterSave($params);
            }
        }
        return $data;
    }

    /**
     * Delete Data
     * =========================================================================================================
     * @param mixed $id
     * @param array $params
     * @return void
     */
    public function delete($id = '', array $params = [])
    {
        $colID = $this->get_colID();
        switch (true) {
            case $id == '' && !empty($params):
                $conditions = isset($params['where']) ? $params['where'] : [];
                break;
            case $id != '' && !empty($params):
                $conditions = array_merge([$colID => (int)$id], isset($params['where']) ? $params['where'] : []);
                break;
            case $id != '' && empty($params):
                $conditions = [$colID => (int)$id];
                break;
            default:
                // code...
                break;
        }
        return $this->run_delete($conditions ?? [$colID => (int)$this->$colID], $params);
    }

    //Get countrie
    public function get_countrie($ctr = '')
    {
        $data = file_get_contents(APP . 'librairies' . DS . 'database' . DS . 'json' . DS . 'countries.json');
        $country = array_filter(array_column(json_decode($data, true), 'name'), function ($countrie) use ($ctr) {
            return $countrie == $ctr;
        }, ARRAY_FILTER_USE_KEY);
        return $country;
    }

    //Partial save
    public function partial_save($data = [], $params = [], $table = '', $index = '')
    {
        if (!empty($table)) {
            $m = str_replace(' ', '', ucwords(str_replace('_', ' ', $table))) . 'Manager';
            $p_data = (new $m())->getAllbyParams($params);
            if ($p_data->count() > 0) {
                $colID = $p_data->get_colID();
                $p_data = current($p_data->get_results());
                $p_data->id = $p_data->$colID;
            } else {
                $p_data->tbl = $table;
                $p_data->relID = $index;
            }
            $p_data->assign($data);
            if ($p_data->save()->count() > 0) {
                $p_data = null;
                return true;
            }
            $p_data = null;
        }
        return false;
    }

    public function validator(array $source = [], array $items = [])
    {
        FH::validate_forms($source, $items, $this);
    }

    //Get selected options
    public function get_Options($selected_optons = [], $m = null)
    {
        $all_options = $m->getAllItem(['return_mode' => 'class'])->get_results();
        if (!$selected_optons) {
            return [];
        }
        return  [array_map(
            function ($option) {
                $colID = $option->get_colID();
                $title = $option->get_colTitle();
                return ['id' => (int)$option->$colID, 'text' => $this->htmlDecode($option->$title)];
            },
            $all_options
        ), array_map(
            function ($id) {
                return $id;
            },
            array_keys($selected_optons)
        )];
    }

    public function notify($userID, $type, $message)
    {
        $fields = ['type' => $type, 'message' => $message, 'userID' => $userID];
        $this->insert($fields);
    }

    //check empty parent items, categories, brands, groups etc...
    public function check_forEmptyParent($parentID = '')
    {
        $childItems = property_exists($this, '_colIndex') ? $this->getAllbyIndex($parentID) : null;
        // $otherlink = $this->search_relatedLinks($parentID, $this->get_tableName(), $this->get_colID());
        $output = '';
        if (isset($childItems) && $childItems->count() > 0) {
            $output .= '<span class="lead text-black-50"> There are releted items : </span>';
            $output .= '<div class="py-2 text-gray ps-3">';
            foreach ($childItems->get_results() as $childItem) {
                $ponctuation = $childItem === end($childItems) ? '.' : ',';
                $coltitle = $childItem->get_colTitle();
                $output .= '<p class="my-0 italic">' . $childItem->$coltitle . $ponctuation . '</p>';
            }

            $output .= ($childItems) ? '</div>' : '';
            $output .= ($childItems) ? '<span class="text-center pt-3" style="font-size:.9rem">Do you really want to delete it ?</span>' : '';
        }
        return $output;
    }

    /**
     * Get Container
     *
     * @return ContainerInterface
     */
    public function get_container() : ContainerInterface
    {
        return self::$container;
    }
}