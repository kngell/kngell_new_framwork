<?php

declare(strict_types=1);

class EntityManager implements EntityManagerInterface
{
    /**
     * @var CrudInterface
     */
    protected CrudInterface $crud;

    /**
     * =====================================================================
     * Main constructor
     * =====================================================================
     * @param CrudInterface $crud
     * @return void
     */
    public function __construct(Crud $crud)
    {
        $this->crud = $crud;
    }

    /**
     * =====================================================================
     * Get Items
     * =====================================================================
     *@inheritDoc
     */
    public function getCrud(): Object
    {
        return $this->crud;
    }
}