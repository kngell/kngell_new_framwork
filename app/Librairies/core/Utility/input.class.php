<?php
declare(strict_types=1);
class Input
{
    protected static ContainerInterface $container;

    /**
     * Main Constructor
     */
    public function __construct()
    {
    }

    public function exists($type)
    {
        switch ($type) {
            case 'post':
                return ($_SERVER['REQUEST_METHOD'] == 'POST') ? true : false;
                break;
            case 'get':
                return ($_SERVER['REQUEST_METHOD'] == 'GET') ? true : false;
                break;
            case 'put':
                return ($_SERVER['REQUEST_METHOD'] == 'PUT') ? true : false;
            break;
            case 'files':
                return ($_SERVER['REQUEST_METHOD'] == 'FILE') ? true : false;
            break;
            default:
                return false;
            break;
        }
    }

    //=======================================================================
    //Rename Keys of Objects
    //=======================================================================
    public function transform_keys($source, $item)
    {
        $S = $source;
        if (isset($item)) {
            foreach ($source as $key => $val) {
                foreach ($item as $k => $v) {
                    if ($key == $k) {
                        $S = $this->_rename_arr_key($key, $v, $S);
                    }
                }
            }
        }

        return $S;
    }

    //internal rename keys helper
    private function _rename_arr_key($oldkey, $newkey, $arr = [])
    {
        if (array_key_exists($oldkey, $arr)) {
            $arr[$newkey] = $arr[$oldkey];
            unset($arr[$oldkey]);

            return $arr;
        } else {
            return false;
        }
    }

    public function extract_key($source, $keyName)
    {
        $s = $source;
        unset($s[$keyName]);
        return $s;
    }

    public function get($input = false)
    {
        $sanitizer = self::$container->load([Sanitizer::class => []])->Sanitizer;
        if (isset($_REQUEST[$input]) && is_array($_REQUEST[$input])) {
            $r = [];
            foreach ($_REQUEST[$input] as $val) {
                $r[] = $sanitizer->clean($val);
            }
            return $r;
        }
        if (!$input) {
            $data = [];
            foreach ($_REQUEST as $field => $value) {
                !is_array($value) ? $data[$field] = $sanitizer->clean($value) : '';
            }
            return $data;
        }
        return isset($_REQUEST[$input]) ? $sanitizer->clean($_REQUEST[$input]) : '';
    }

    public function getParams($source)
    {
        if (isset($source['by_user'])) {
            return json_decode($this->get('by_user'));
        } else {
            return [(int)$this->get('start'), (int) $this->get('max'), (int)$this->get('id')];
        }
    }

    public function add_slashes($data)
    {
        return addslashes($data);
    }
}