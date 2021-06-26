<?php

class PageSitemapManager extends Model
{
    protected $_colID = 'psmID';
    protected $_table = 'page_sitemap';
    protected $_modelName;
    public $psmID;
    public $page_title;
    public $page_url;
    public $created_at;
    public $updated_at;
    public $deleted;

    //=======================================================================
    //construct
    //=======================================================================
    public function __construct()
    {
        parent::__construct();
        $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table))) . 'Manager';
    }

    //=======================================================================
    //Getters & setters
    //=======================================================================

    //=======================================================================
    //Operations
    //=======================================================================
}
