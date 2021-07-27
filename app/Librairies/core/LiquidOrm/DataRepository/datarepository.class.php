<?php

declare(strict_types=1);

use Magma\Utility\Paginator;

class DataRepository implements DataRepositoryInterface
{
    protected EntityManagerInterface $em;

    /**
     * Main constructor
     * ====================================================================
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManager $em = null)
    {
        $this->em = $em;
    }

    private function isArray(array $conditions) :void
    {
        if (!is_array($conditions)) {
            throw new DataRepositoryInvalidArgumentException('Argument Supplied is not an array');
        }
    }

    private function isempty(int $id) : bool
    {
        if (empty($id)) {
            throw new DataRepositoryInvalidArgumentException('Argument shuold not be empty');
        }
        return true;
    }

    /**
     * Create new entrie
     * ====================================================================
     * @param array $fields
     * @return integer|null
     */
    public function create(array $fields) :?int
    {
        try {
            return $this->em->getCrud()->create($fields);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Delete from data base
     * ====================================================================
     * @param array $conditions
     * @return integer|null
     */
    public function delete(array $conditions) : ?int
    {
        try {
            return $this->em->getCrud()->delete($conditions);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(array $fields, array $conditions) : ?int
    {
        try {
            return $this->em->getCrud()->update($fields, $conditions);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Find by ID
     * ====================================================================
     * @param integer $id
     * @return array
     */
    public function findByID(int $id): array
    {
        if ($this->isempty($id)) {
            try {
                return $this->findOneBy([$this->em->getCrud()->getSchemaID() => $id], []);
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }

    /**
     * Find One element by
     *====================================================================
     * @param array $conditions
     * @param array $options
     * @return mixed
     */
    public function findOneBy(array $conditions, array $options) :mixed
    {
        $this->isArray($conditions);
        try {
            return $this->em->getCrud()->read([], $conditions, [], $options);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Get All
     * ====================================================================
     * @return array
     */
    public function findAll(): array
    {
        try {
            // return $this->im->getCrud()->read();
            return $this->findBy();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Get All By
     * ====================================================================
     * @param array $selectors
     * @param array $conditions
     * @param array $parameters
     * @param array $options
     * @return mixed
     */
    public function findBy(array $selectors = [], array $conditions = [], array $parameters = [], array $options = [])
    {
        try {
            return $this->em->getCrud()->read($selectors, $conditions, $parameters, $options);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function findObjectBy(array $conditions = [], array $selectors = []): object
    {
        $this->isArray($conditions);
        try {
            return $this->em->getCrud()->get($selectors, $conditions);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Search Data
     *====================================================================
     * @param array $selectors
     * @param array $conditions
     * @param array $parameters
     * @param array $options
     * @return array
     */
    public function findBySearch(array $selectors = [], array $conditions = [], array $parameters = [], array $options = []): array
    {
        $this->isArray($conditions);
        try {
            return $this->em->getCrud()->search($selectors, $conditions, $parameters, $options);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Find data and delete it
     * ====================================================================
     * @param array $conditions
     * @return boolean
     */
    public function findByIDAndDelete(array $conditions): bool
    {
        $this->isArray($conditions);
        try {
            $result = $this->findOneBy($conditions, []);
            if ($result != null && $result > 0) {
                $delete = $this->em->getCrud()->delete($conditions);
                if ($delete) {
                    return true;
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Find and Update
     * ====================================================================
     * @param array $fields
     * @param integer $id
     * @return boolean
     */
    public function findByIdAndUpdate(array $fields = [], int $id = 0): bool
    {
        $this->isArray($fields);
        try {
            $result = $id > 0 ? $this->findOneBy([$this->em->getCrud()->getSchemaID() => $id], []) : null;
            if ($result != null && count($result) > 0) {
                $param = (!empty($fields)) ? array_merge([$this->im->getCrud()->getSchemaID()->$id], $fields) : $fields;
                $update = $this->em->getCrud()->update($param, $this->im->getCrud()->getSchemaID());
                if ($update) {
                    return true;
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Search with pagination
     *====================================================================
     * @param array $arg
     * @param object $request
     * @return array
     */
    public function findWithSearchAndPagin(Object $request, array $args): array
    {
        list($conditions, $totalRecords) = $this->getCurrentQueryStatus($request, $args);
        $sorting = new Sortable($args['sort_columns']);
        $pagin = new Paginator($totalRecords, $args['records_per_page'], $request->query->getInt('page', 1));
        $parameters = ['limit' => $args['records_per_page'], 'offset' => $pagin->getOffset()];
        $optionnals = ['orderby' => $sorting->getColumn() . ' ' . $sorting->getDirection()];

        if ($request->query->getAlnum($args['filter_alias'])) {
            $searchRequest = $request->query->getAlnum($args['filter_alias']);
            if (is_array($args['filter_by'])) {
                for ($i = 0; $i < count($args['filter_by']); $i++) {
                    $searchCond = [$args['filter_by'][$i] => $searchRequest];
                }
            }
            $results = $this->findBySearch($args['filter_by'], $searchCond);
        } else {
            $queryCond = array_merge($args['additionnal_conditions'], $conditions);
            $results = $this->findBy($args['selectors'], $queryCond, $parameters, $optionnals);
        }
        return [
            $results,
            $pagin->getPage(),
            $pagin->getTotalPages(),
            $totalRecords,
            $sorting->sortDirection(),
            $sorting->sortDescAsc(),
            $sorting->getClass(),
            $sorting->getColumn(),
            $sorting->getDirection()
        ];
    }

    private function getCurrentQueryStatus(Object $request, array $args)
    {
        $totalRecords = 0;
        $conditions = [];
        $req = $request->query;
        $status = $req->getAlnum($args['query']);
        $searchResults = $req->getAlnum($args['filter_alias']);
        if ($searchResults) {
            for ($i = 0; $i < count($args['filter_by']); $i++) {
                $conditions = [$args['filter_by'][$i] => $searchResults];
                $totalRecords = $this->em->getCrud()->countRecords($conditions, $args['filter_by'][$i]);
            }
        } elseif ($status) {
            $conditions = [$args['query'] => $status];
            $totalRecords = $this->em->getCrud()->countRecords($conditions);
        } else {
            $conditions = [];
            $totalRecords = $this->em->getCrud()->countRecords($conditions);
        }
        return [
            $conditions, $totalRecords
        ];
    }

    /**
     * Find and retur self
     *====================================================================
     * @param integer $id
     * @param array $selectors
     * @return DataRepositoryInterface
     */
    public function findAndReturn(int $id, array $selectors = []): DataRepositoryInterface
    {
        return $this;
    }

    public function get_tableColumn(array $options): object
    {
        try {
            return $this->em->getCrud()->show($options);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}