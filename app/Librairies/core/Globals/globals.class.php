<?php
declare(strict_types=1);

class Globals extends GlobalsManager
{
    private array $get;

    public function __construct()
    {
        $this->get = filter_input_array(INPUT_GET);
    }

    /**
     * Get $_GET
     *
     * @return array
     */
    public function getGet() : array
    {
        return $this->get;
    }
}