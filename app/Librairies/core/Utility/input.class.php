<?php
declare(strict_types=1);
class Input
{
    protected ContainerInterface $container;

    /**
     * Main Constructor
     */
    public function __construct(Sanitizer $sanitizer)
    {
        $this->sanitizer = $sanitizer;
    }

    public function set_container() : self
    {
        if (!isset($this->container)) {
            $this->container = Container::getInstance();
        }
        return $this;
    }

    public function exists($type)
    {
        $global = $this->container->make(GlobalVariables::class)->getServer('REQUEST_METHOD');
        switch ($type) {
            case 'post':
                return ($global == 'POST') ? true : false;
                break;
            case 'get':
                return ($global == 'GET') ? true : false;
                break;
            case 'put':
                return ($global == 'PUT') ? true : false;
            break;
            case 'files':
                return ($global == 'FILE') ? true : false;
            break;
            default:
                return false;
            break;
        }
    }

    /**
     * Transform Key -> transform source key from old to new key when present on $item
     * ============================================================================================
     * @param array $source
     * @param array $item
     * @return void
     */
    public function transform_keys(array $source = [], array | null $item = [])
    {
        $S = $source;
        if (isset($item)) {
            foreach ($source as $key => $val) {
                if (isset($item[$key])) {
                    $S = $this->_rename_arr_key($key, $item[$key], $S);
                }
            }
        }

        return $S;
    }

    /**
     * Get Html Decode texte
     * =========================================================================================================
     * @param string $str
     * @return string
     */
    public function htmlDecode(string $str) : string
    {
        return !empty($str) ? htmlspecialchars_decode(html_entity_decode($str), ENT_QUOTES) : '';
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
        $sanitizer = $this->container->make(Sanitizer::class);
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