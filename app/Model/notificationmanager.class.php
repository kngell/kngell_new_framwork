<?php
declare(strict_types=1);
class NotificationManager extends Model
{
    protected string $_colID = 'notID';
    protected string $_table = 'notification';
    protected string $_colIndex = 'userID';
    protected string $_colTitle = 'message';
    protected $_modelName;

    /**
     * Main constructor
     * =======================================================================
     */
    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
        $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table))) . 'Manager';
    }

    //=======================================================================
    //Getters & setters
    //=======================================================================

    //=======================================================================
    //Operations
    //=======================================================================
}