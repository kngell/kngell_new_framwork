<?php
declare(strict_types=1);
class CategoriesManager extends Model
{
    protected string $_colID = 'catID';
    protected string $_colTitle = 'categorie';
    protected string $_colIndex = 'parentID';
    protected string $_table = 'categories';
    protected array $checkboxes = ['status'];

    //=======================================================================
    //Construct
    //=======================================================================
    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
        $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table))) . 'Manager';
    }

    public function getAllCategories()
    {
        $tables = ['table_join' => ['categories' => ['*'], 'brand' => ['br_name']]];
        $data = [
            'join' => 'LEFT JOIN',
            'rel' => [['brID', 'brID']],
            'return_mode' => 'class'
        ];
        $uc = $this->getAllItem($data, $tables);
        return $uc->count() > 0 ? $uc->get_results() : [];
    }

    public function getPostsFromCategories()
    {
        $this->_table = 'SELECT p.* FROM posts p INNER JOIN post_categorie pc ON pc.postID = p.postID ';
        $data_query = ['where' => ['catID' => (int)$this->catID], 'group_by' => 'pc.postID', 'return_mode' => 'class', 'class' => 'PostsManager'];
        $results = $this->getAllItem($data_query);
        $this->_table = 'categories';
        return $results;
    }

    public function countPostByCategorie()
    {
        $this->_table = 'post_categorie';
        $data_query = ['where' => ['catID' => $this->catID], 'select' => 'COUNT(*) as number', 'return_type' => 'single'];
        $results = $this->getAllItem($data_query);
        $this->_table = 'categories';
        return $results;
    }

    public function popularTags()
    {
        $this->_table = 'SELECT COUNT(*) AS number,pc.catID, c.categorie FROM post_categorie pc inner join categories c ON c.catID=pc.catID ';
        $data_query = ['group_by' => 'pc.catID', 'order_by' => 'number DESC', 'return_mode' => 'class', 'class' => 'CategoriesManager'];
        $results = $this->getAllItem($data_query);
        $this->_table = 'categories';
        return $results;
    }

    // Get succes message
    public function get_successMessage($method = '', $action = '')
    {
        switch ($method) {
            case 'update':
                return 'Categorie mise a jour avec success!';
                break;
            case 'delete':
                return 'Catégorie supprimée!!';
                break;
            case 'Add':
                return 'Catégorie ajoutée avec success!!';
                break;

            default:
                return 'votre requête est bien prise en compte!';
                break;
        }
    }

    //=======================================================================
    //Operations
    //=======================================================================
    //After delete categorie children
    public function afterDelete($params = [])
    {
        if (isset($params) && is_array($params)) {
            $categories = $this->getAllbyIndex($params[$this->get_colID()]);
            if ($categories->count() > 0) {
                foreach ($categories->get_results() as $categorie) {
                    $key = $categorie->get_colID();
                    $delete = $this->delete($categorie->$key);
                }
                return $delete;
            }
        }
        return true;
    }

    public function get_fieldName(string $table = '')
    {
        switch ($table) {
            case 'categories':
                return 'parentID';
                break;
            case 'taxes':
                return 'categorieID';
                break;

            default:
                return 'categorie';
                break;
        }
    }

    public function beforeSave(array $params = []) :mixed
    {
        parent::beforeSave($params);
        // Manage chechboxes
        return true;
    }
}