<?php
declare(strict_types=1);

class CountriesManager
{
    protected string $_colID = 'id';
    protected string $_table = 'countries';
    protected string $_colTitle = 'name';

    //=======================================================================
    //construct
    //=======================================================================
    public function __construct()
    {
    }

    //=======================================================================
    //Getters & setters
    //=======================================================================
    public function get_fieldName(string $table = '')
    {
        return 'country_code';
    }

    public function get_colID()
    {
        return $this->_colID;
    }

    public function get_colTitle()
    {
        return $this->_colTitle;
    }

    public function get_tableName()
    {
        return $this->_table;
    }

    public function get_successMessage(string $method = '', array $params = [])
    {
        switch ($method) {
            case 'update':
                if ($params == 'custom_message') {
                    return FH::showMessage('success text-center', 'Entrepôt mis à jour ave succès');
                }
                return 'Profil mis a jour avec succès!';
                break;
            case 'delete':
                return 'Entrepôt supprimé !';
                break;
            default:
                return 'Entrepôt créee avec success!';
                break;
        }
    }

    public function get_Options(array $ctr = [], Object $m)
    {
        $data = file_get_contents(FILES . 'json' . DS . 'data' . DS . 'countries.json');
        $countries = array_column(json_decode($data, true), 'name');
        $response = [];
        $matches = [];
        foreach ($countries as $key => $value) {
            $response[] = ['id' => $key, 'text' => $value];
            if ($key == $ctr[$m->colOptions]) {
                $matches[] = $key;
            }
        }
        return [$response, $matches];
    }

    //=======================================================================
    //Operations
    //=======================================================================
}