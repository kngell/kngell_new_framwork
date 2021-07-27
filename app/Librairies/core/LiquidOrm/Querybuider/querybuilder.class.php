<?php

declare(strict_types=1);

class QueryBuilder extends AbstractQueryBuilder
{
    /**
     * =====================================================================
     * Main constructor
     * =====================================================================
     *@return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * =====================================================================
     * Build query
     * =====================================================================
     * @param array $arg
     *@return self
     */
    public function buildQuery(array $args = []) :self
    {
        if (count($args) < 0) {
            throw new BaseInvalidArgumentException('Your BuildQuery method has no defined argument. Please fix this');
        }
        $arg = array_merge(self::SQL_DEFAULT, $args);
        $this->key = $arg;
        return $this;
    }

    private function isValidquerytype(string $type):bool
    {
        if (in_array($type, self::QUERY_TYPES)) {
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
                $keys = implode(', ', array_keys($this->key['fields']));
                $values = ':' . implode(', :', array_keys($this->key['fields']));
                $this->sql = 'INSERT INTO ' . $this->key['table'] . ' (' . $keys . ') VALUES (' . $values . ')';
                return $this->sql;
            }
        }
        return false;
    }

    /**
    * Select query
    * =====================================================================
    * @inheritDoc
    * @return string
    */
    public function select():string
    {
        if ($this->isValidquerytype('select')) {
            if (!$this->sql = $this->join($this->key['table_join'], $this->key['extras'])) {
                if (strpos($this->key['table'], 'SELECT') !== false) {
                    $this->sql = $this->key['table'];
                } else {
                    $selectors = (!empty($this->key['selectors'])) ? implode(' ,', $this->key['selectors']) : '*';
                    if (isset($this->key['aggregate']) && $this->key['aggregate']) {
                        $this->sql = "SELECT {$this->key['aggregate']}({$this->key['aggregate_field']}) FROM {$this->key['table']}";
                    } else {
                        $this->sql = "SELECT {$selectors} FROM {$this->key['table']}";
                    }
                }
            }
            //where condition
            $this->sql .= $this->where();
            //Group by
            $this->sql .= $this->groupBy();
            //Order by
            $this->sql .= $this->orderByQuery();
            //Limits,Offset
            $this->sql .= $this->queryOffset();
            return $this->sql . (isset($this->key['where']['bind_array']) ? '&' . serialize($this->key['where']['bind_array']) : '');
        }
        return false;
    }

    /**
     * Show or get column from data base
     *
     * @return string
     */
    public function show() : string
    {
        if ($this->isValidquerytype('show')) {
            return $this->sql = 'SHOW COLUMNS FROM ' . "{$this->key['table']}";
        }
        return false;
    }

    /**
    * Update query
    * =====================================================================
    * @inheritDoc
    * @return string
    */
    public function update():string
    {
        if ($this->isValidquerytype('update')) {
            if (is_array($this->key['fields']) && count($this->key['fields']) > 0) {
                $keyValues = '';
                //Fields
                $i = 0;
                foreach ($this->key['fields'] as $key => $val) {
                    $add = ($i > 0) ? ', ' : '';
                    $keyValues .= "$add" . "$key=:$key";
                    $i++;
                }
                //Query
                $this->sql = 'UPDATE ' . $this->key['table'] . ' SET ' . $keyValues . $this->where();
                return $this->sql . (isset($this->key['where']['bind_array']) ? '&' . serialize($this->key['where']['bind_array']) : '');
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
            if (is_array($this->key['conditions']) && count($this->key['conditions']) > 0) {
                $this->sql = 'DELETE FROM ' . $this->key['table'] . $this->where();
                return $this->sql . (isset($this->key['where']['bind_array']) ? '&' . serialize($this->key['where']['bind_array']) : '');
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
}