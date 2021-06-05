<?php

declare(strict_types=1);

class QueryBuilder implements QueryBuilderInterface
{
    protected array $key;
    protected string $sql;
    protected const SQL_DEFAULT = [
        'selectors' => [],
        'replaces' => false,
        'distinct' => false,
        'from' => [],
        'where' => null,
        'and' => [],
        'or' => [],
        'orderBy' => [],
        'fields' => [],
        'primary_key' => '',
        'table' => '',
        'type' => '',
        'custom' => '',
        'params' => []
    ];
    protected const QUERY_TYPE = ['insert', 'select', 'update', 'delete', 'custom'];

    /**
     * =====================================================================
     * Main constructor
     * =====================================================================
     *@return void
     */
    public function __construct()
    {
    }

    /**
     * =====================================================================
     * Build query
     * =====================================================================
     * @param array $arg
     *@return self
     */
    public function builQuery(array $arg = []) :self
    {
        if (count($arg) < 0) {
            throw new QueryBuilderInvalidArgExceptions();
        }
        $arg = array_merge(self::SQL_DEFAULT, $arg);
        $this->key = $arg;
        return $this;
    }

    private function isValidquerytype(string $type):bool
    {
        if (in_array($type, self::QUERY_TYPE)) {
            return true;
        }
        return false;
    }

    /**
     * =====================================================================
     * Insert queery
     * =====================================================================
     * @inheritDoc
     * @return string
     */
    public function insert():string
    {
        if ($this->isValidquerytype('insert')) {
            if (is_array($this->key['fields']) && count($this->key['fields']) > 0) {
                $index = array_keys($this->key['fields']);
                $values = [implode(', ', $index), ':' . implode(', :', $index)];
                $this->sql = "INSERT INTO {$this->key['table']} ({$values[0]}) VALUES ({$values[1]})";
                return $this->sql;
            }
        }
        return false;
    }

    /**
    * =====================================================================
    * Select query
    * =====================================================================
    * @inheritDoc
    * @return string
    */
    public function select():string
    {
        if ($this->isValidquerytype('select')) {
            if (is_array($this->key['fields']) && count($this->key['fields']) > 0) {
                $selectors = (!empty($this->key['selectors'])) ? implode(' ,', $this->key['selectors']) : '*';
                $this->sql = "SELECT {$selectors} FROM {$this->key['table']}";
                $this->sql = $this->where();
                return $this->sql;
            }
        }
        return false;
    }

    /**
    * =====================================================================
    * Update query
    * =====================================================================
    * @inheritDoc
    * @return string
    */
    public function update():string
    {
        if ($this->isValidquerytype('update')) {
            if (is_array($this->key['fields']) && count($this->key['fields']) > 0) {
                foreach ($this->key['fields'] as $field) {
                    $values = '';
                    if ($field !== $this->key['primary_key']) {
                        $values .= $field . '= :' . $field . ', ';
                    }
                }
                $values = substr_replace($values, '', -2);
                if (count($this->key['fields']) > 0) {
                    $this->sql = "UPDATE {$this->key['table']} SET {$values} WHERE {$this->key['primary_key']} = :{$this->key['primary_key']} LIMIT 1";
                    if (isset($this->key['primary_key']) && $this->key['primary_key'] == 0) {
                        unset($this->key['primary_key']);
                        $this->sql = "UPDATE {$this->key['table']} SET {$values}";
                    }
                }
                return $this->sql;
            }
        }
        return false;
    }

    /**
    * =====================================================================
    * Delete query
    * =====================================================================
    * @inheritDoc
    * @return string
    */
    public function delete():string
    {
        if ($this->isValidquerytype('delete')) {
            if (is_array($this->key['fields']) && count($this->key['fields']) > 0) {
                $index = array_keys($this->key['conditions']);
                $this->sql = "DELETE from {$this->key['table']} WHERE {$index[0]} = :{$index[0]} LIMIT 1";
                $bulkdelete = array_values($this->key['fields']);
                if (is_array($bulkdelete) && count($bulkdelete) > 1) {
                    for ($i = 0; $i < count($bulkdelete); $i++) {
                        $this->sql = "DELETE FROM {$this->key['table']} WHERE {$index[0]} = :{$index[0]}";
                    }
                }
                return $this->sql;
            }
        }
        return false;
    }

    /**
    * =====================================================================
    * Search query
    * =====================================================================
    * @inheritDoc
    * @return string
    */
    public function search():string
    {
        if ($this->isValidquerytype('search')) {
            if (is_array($this->key['fields']) && count($this->key['fields']) > 0) {
                $index = array_keys($this->key['conditions']);
                $this->sql = "DELETE from {$this->key['table']} WHERE {$index[0]} = :{$index[0]} LIMIT 1";
                $bulkdelete = array_values($this->key['fields']);
                if (is_array($bulkdelete) && count($bulkdelete) > 1) {
                    for ($i = 0; $i < count($bulkdelete); $i++) {
                        $this->sql = "DELETE FROM {$this->key['table']} WHERE {$index[0]} = :{$index[0]}";
                    }
                }
                return $this->sql;
            }
        }
        return false;
    }

    /**
    * =====================================================================
    * Custom query
    * =====================================================================
    * @inheritDoc
    * @return string
    */
    public function customQuery():string
    {
        if ($this->isValidquerytype('custom')) {
            if (is_array($this->key['fields']) && count($this->key['fields']) > 0) {
                $index = array_keys($this->key['conditions']);
                $this->sql = "DELETE from {$this->key['table']} WHERE {$index[0]} = :{$index[0]} LIMIT 1";
                $bulkdelete = array_values($this->key['fields']);
                if (is_array($bulkdelete) && count($bulkdelete) > 1) {
                    for ($i = 0; $i < count($bulkdelete); $i++) {
                        $this->sql = "DELETE FROM {$this->key['table']} WHERE {$index[0]} = :{$index[0]}";
                    }
                }
                return $this->sql;
            }
        }
        return false;
    }

    /**
      * =====================================================================
      * Where condition
      * =====================================================================
      *
      * @return string
      */
    public function where()
    {
        if (isset($this->key['conditions']) && $this->key['conditions'] != '') {
            if (is_array($this->key['conditions'])) {
                $sort = [];
                foreach (array_keys($this->key['conditions']) as $wherekey => $where) {
                    if (isset($where) && $where != '') {
                        $sort = $where . ' = :' . $where;
                    }
                }
                if (count($this->key['conditions']) > 0) {
                    $this->sql .= ' WHERE ' . implode(' AND ', $sort);
                }
            }
        } elseif (empty($this->key['conditions'])) {
            $this->sql = ' WHERE 1';
        }
        if (isset($this->key['orderBy']) && $this->key['orderBy'] != '') {
            $this->sql .= ' OORDER BY ' . $this->key['orderBy'] . ' ';
        }
        if (isset($this->key['limit']) && $this->key['offset'] != -1) {
            $this->sql .= ' LIMIT :offset, :limit' . ' ';
        }
        return $this->sql;
    }
}
