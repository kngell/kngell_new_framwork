<?php
class PostFileUrlManager extends Model
{
    protected $_table = 'post_file_url';
    protected $_colID = 'pfuID';
    protected $_Index = 'imgID';
    public $pfuID;
    public $imgID;
    public $fileUrl;

    //=======================================================================
    //construct
    //=======================================================================
    public function __construct()
    {
        parent::__construct();
        $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table))) . 'Manager';
    }

    //=======================================================================
    //Getters
    //=======================================================================
    public function getAllbyIndex($index_value)
    {
        $this->_table = 'SELECT * FROM ' . $this->_table . ' WHERE ' . $this->_Index . ' ' . $index_value;
        $results = $this->find(['return_mode' => 'class']);
        $this->_table = 'post_file_url';
        return $results;
    }
}
