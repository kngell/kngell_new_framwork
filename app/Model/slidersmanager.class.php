<?php
declare(strict_types=1);
class SlidersManager extends Model
{
    protected $_colID = 'slID';
    protected $_table = 'sliders';

    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
        $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table))) . 'Manager';
    }

    public function get_successMessage(string $method = '', ?array $params = []) : ?string
    {
        switch ($method) {
            case 'update':
                return 'slider a jour avec succès!';
                break;
            case 'delete':
                return 'slider supprimé!';
                break;
            default:
                return 'Slider créee avec success!';
                break;
        }
    }
}