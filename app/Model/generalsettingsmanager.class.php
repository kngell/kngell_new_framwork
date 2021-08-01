<?php
declare(strict_types=1);
class GeneralSettingsManager extends Model
{
    protected $_colID = 'setID';
    protected $_table = 'general_settings';
    protected $_modelName;

    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
        $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table))) . 'Manager';
    }

    public function beforeSave(array $params = []) :array
    {
        parent::beforeSave();
        if (strstr(strtolower($params['setting_key']), 'link') || strstr(strtolower($params['setting_name']), 'link')) {
            $this->setting_key = $params['setting_key'] = strtolower($params['setting_key']);
            if (!strstr($params['setting_key'], 'link')) {
                $this->setting_key = $params['setting_key'] = $params['setting_key'] . '_link';
            }
            if (strstr($params['setting_key'], ' ')) {
                $this->setting_key = $params['setting_key'] = str_replace(' ', '_', $params['setting_key']);
            }
            if (strstr($params['value'], 'http://')) {
                $this->value = $params['value'] = str_replace('http://', '', $params['value']);
            }
            if (strstr($params['value'], 'www') && !strstr($params['value'], 'https://')) {
                $this->value = $params['value'] = str_replace('www.', '', $params['value']);
            }
            if (!strstr($params['value'], 'https://')) {
                $this->value = $params['value'] = 'https://www.' . $params['value'];
            }
        }
        return $params;
    }

    public function get_successMessage(string $method = '', ?array $params = []) : ?string
    {
        switch ($method) {
            case 'update':
                return 'Paramètre a jour avec succès!';
                break;
            case 'delete':
                return 'Paramètre supprimé!';
                break;
            default:
                return 'Paramètre créee avec success!';
                break;
        }
    }
}