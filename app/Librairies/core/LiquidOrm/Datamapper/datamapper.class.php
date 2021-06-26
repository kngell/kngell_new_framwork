<?php

declare(strict_types=1);

class DataMapper extends AbstractDataMapper
{
    /**
     * Databaseconexxion interface
     */
    private DatabaseConnexionInterface $_con;
    /**
     *
     */
    private PDOStatement $_query;

    private int $_count = 0;
    private $_results;
    private $bind_arr = [];

    /**
     * Main constructor
     * =========================================================================================================
     *
     */
    public function __construct(DatabaseConnexionInterface $_con)
    {
        $this->_con = $_con;
    }

    /**
     * Private isempty
     * =========================================================================================================
     *@param $value
     *@param string  $erMsg
     */
    private function isEmpty($value = null, string $errMsg = null)
    {
        if (empty($value)) {
            throw new DataMapperExceptions($errMsg);
        }
    }

    /**
     * Private is an array
     * =========================================================================================================
     *@param $value
     *@param string  $erMsg
     */
    private function isArray($value = null, string $errMsg = null)
    {
        if (!is_array($value)) {
            throw new DataMapperExceptions('Your Argument must be an array');
        }
    }

    /**
     * Prepare statement
     * =========================================================================================================
     *@inheritDoc
     */
    public function prepare(string $sql):self
    {
        $this->_query = $this->_con->open()->prepare($sql);
        return $this;
    }

    /**
    *
     * @inheritDoc
    */
    public function bind_type($value)
    {
        try {
            switch ($value) {
            case is_bool($value):
            case intval($value):
                $type = PDO::PARAM_INT;
            break;
            case is_null($value):
                $type = PDO::PARAM_NULL;
            break;

            default:
                $type = PDO::PARAM_STR;
            break;
        }
            return $type;
        } catch (\DataMapperExceptions $ex) {
            throw $ex;
        }
    }

    /**
     * Binding the given values of the query
     * =========================================================================================================
     * @inheritDoc
     */
    public function bind($param, $value, $type = null)
    {
        switch (is_null($type)) {
            case is_int($value):
                $type = PDO::PARAM_INT;
            break;
            case is_bool($value):
                $type = PDO::PARAM_BOOL;
            break;
            case is_null($value):
                $type = PDO::PARAM_NULL;
            break;
            default:
                $type = PDO::PARAM_STR;
        }
        $this->_query->bindValue($param, $value, $type);
    }

    // /**
    //  * Bian an array
    //  * =========================================================================================================
    //  * @param array $fields
    //  * @throws DataMapperExceptions
    //  * @return PDOStatement
    //  */
    // protected function bindValuesxxxx(array $fields = []) :PDOStatement
    // {
    //     $this->isArray($fields);
    //     foreach ($fields as $key => $value) {
    //         $this->_query->bindValue(':' . $key, $value, $this->bind_type($value));
    //     }
    //     return $this->_query;
    // }

    /**
     * Bind Values
     * =========================================================================================================
     * @param array $fields
     * @throws DataMapperExceptions
     * @return PDOStatement
     */
    protected function bindValues(array $fields = []) : PDOStatement
    {
        if (!empty($fields)) {
            if (isset($fields['bind_array'])) {
                unset($fields['bind_array']);
            }
            foreach ($fields as $key => $val) {
                if (is_array($val)) {
                    switch (true) {
                        case isset($val['operator']) && in_array($val['operator'], ['!=', '>', '<', '>=', '<=']):
                            $this->bind(":$key", $val['value']);
                            break;
                        case isset($val['operator']) && in_array($val['operator'], ['NOT IN', 'IN']):
                            if (!empty($this->bind_arr)) {
                                foreach ($this->bind_arr as $k => $v) {
                                    $this->bind(":$k", $v);//implode("', '", $val['value'])
                                }
                            }
                            break;
                        default:
                            $this->bind(":$key", $val['value']);
                            break;
                    }
                } else {
                    $this->bind(":$key", $val);
                }
            }
        }
        return $this->_query;
    }

    /**
     * Bian an array
     * =========================================================================================================
     * @inheritDoc
    */
    public function bindParameters(array $fields = [], bool $isSearch = false):self
    {
        if (is_array($fields)) {
            $type = ($isSearch === false) ? $this->bindValues($fields) : $this->biendSearchValues($fields);
            if ($type) {
                return $this;
            }
        }
        return false;
    }

    /**
     * Bind search values
     * =========================================================================================================
     * @param array $fields
     */
    protected function biendSearchValues(array $fields = [])
    {
        $this->isArray($fields);
        foreach ($fields as $key => $value) {
            $this->_query->bindValue(':' . $key, '%' . $value . '%', $this->bind_type($value));
        }
        return $this->_query;
    }

    /**
      * Get numberof row
      * =========================================================================================================
      *@inheritDoc
      */
    public function numrow(): int
    {
        if ($this->_query) {
            $this->_count = $this->_query->rowCount();
            return $this->_count;
        }
    }

    /**
    * Execute
    * =========================================================================================================
    *@inheritDoc
    */
    public function execute():void
    {
        if ($this->_query) {
            $this->_query->execute();
        }
    }

    /**
      * Single results as object
      * =========================================================================================================
      *@inheritDoc
      */
    public function result(): Object
    {
        if ($this->_query) {
            return $this->_query->fetch(PDO::FETCH_OBJ);
        }
    }

    /**
    * Results as array
    * =========================================================================================================
    *@inheritDoc
    */
    public function results(array $options = []) : self
    {
        if ($this->_query) {
            $this->_results = $this->select_result($this->_query, $options);
            return $this;
        }
    }

    /**
    *  Get las insert ID
    * =========================================================================================================
    *   *@inheritDoc
    */
    public function getLasID(): int
    {
        try {
            if ($this->_con->open()) {
                $lastID = $this->_con->open()->lastInsertId();
                if (!empty($lastID)) {
                    return intval($lastID);
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * persist Method
     * ==================================================================================================
     * @param string $sql
     * @param array $parameters
     *
     */
    public function persist(string $sql = '', array $parameters = [])
    {
        try {
            $sql = $this->cleanSql($sql);
            return $this->prepare($sql)->bindParameters($parameters)->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Build Query parametters
     * ====================================================================================================
     * Merge conditions
     * @param array $conditions
     * @param array $parameters
     * @return array
     *
     */
    public function buildQueryParameters(array $conditions = [], array $parameters = []): array
    {
        return (!empty($parameters) || !empty($conditions)) ? array_merge($parameters, $conditions) : $parameters;
    }

    /**
     * @inheritDoc
     */
    public function column()
    {
        if ($this->_query) {
            return $this->_query->fetchColumn();
        }
    }

    public function count()
    {
        return $this->_count;
    }

    public function get_results()
    {
        return $this->_results;
    }

    public function cleanSql(string $sql)
    {
        $sqlArr = explode('&', $sql);
        if (isset($sqlArr) & count($sqlArr) > 1) {
            $this->bind_arr = unserialize($sqlArr[1]);
        }
        return $sqlArr[0];
    }
}