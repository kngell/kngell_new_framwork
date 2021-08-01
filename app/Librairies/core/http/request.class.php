<?php
declare(strict_types=1);
class Request extends HttpGlobals
{
    protected Sanitizer $sanitizer;

    /**
     * Main constructor
     * ==================================================================================
     */
    public function __construct(Sanitizer $sanitizer)
    {
        $this->sanitizer = $sanitizer;
    }

    /**
     * Get Path from blobals
     * ==================================================================================
     * @return string
     */
    public function getPath() : string
    {
        $path = $this->getGet('url') ?? '/';
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
    }

    public function getPathReferer() : string
    {
        $path = $this->getServer('HTTP_REFERER') ?? '/';
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
    }

    /**
     * Get Http Method
     * ==================================================================================
     * @return string
     */
    public function getHttpMethod() : string
    {
        return strtolower($this->getServer('REQUEST_METHOD'));
    }

    public function exists($type)
    {
        $global = $this->getHttpMethod();
        switch ($type) {
            case 'post':
                return ($global == 'post') ? true : false;
                break;
            case 'get':
                return ($global == 'get') ? true : false;
                break;
            case 'put':
                return ($global == 'put') ? true : false;
            break;
            case 'files':
                return ($global == 'file') ? true : false;
            break;
            default:
                return false;
            break;
        }
    }

    /**
     * Transform Key -> transform source key from old to new key when present on $item
     * ==================================================================================
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
     * Rename keys
     * ==================================================================================
     * @param string $oldkey
     * @param string $newkey
     * @param array $arr
     * @return array|null
     */
    private function _rename_arr_key(string $oldkey, string $newkey, array $arr = []) : ?array
    {
        if (array_key_exists($oldkey, $arr)) {
            $arr[$newkey] = $arr[$oldkey];
            unset($arr[$oldkey]);
            return $arr;
        } else {
            return false;
        }
    }

    /**
     * Get Data From user input
     * ==================================================================================
     * @param string $input
     * @return mixed
     */
    public function get(string $input = '') : mixed
    {
        if (isset($_REQUEST[$input]) && is_array($_REQUEST[$input])) {
            $r = [];
            foreach ($_REQUEST[$input] as $val) {
                $r[] = $this->sanitizer->clean($val);
            }
            return $r;
        }
        if (!$input) {
            $data = [];
            foreach ($_REQUEST as $field => $value) {
                !is_array($value) ? $data[$field] = $this->sanitizer->clean($value) : '';
            }
            return $data;
        }
        return isset($_REQUEST[$input]) ? $this->sanitizer->clean($_REQUEST[$input]) : '';
    }

    /**
     * Get Params
     * ==================================================================================
     * @param array $source
     * @return array
     */
    public function getParams(array $source) : array
    {
        if (isset($source['by_user'])) {
            return json_decode($this->get('by_user'));
        } else {
            return [(int)$this->get('start'), (int) $this->get('max'), (int)$this->get('id')];
        }
    }

    public function getFiles() : array
    {
        return parent::getFiles();
    }

    // public function getBody()
    // {
    //     $body = [];
    //     if ($this->getHttpmethod() === 'get') {
    //         foreach ($this->global->getGet() as $key => $value) {
    //             $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
    //         }
    //     }
    //     if ($this->getHttpmethod() === 'post') {
    //         foreach ($this->global->getPost() as $key => $value) {
    //             $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
    //         }
    //     }
    //     return $body;
    // }

    /**
     * Check if Http is get request
     * ==================================================================================
     * @return boolean
     */
    public function isGet() : bool
    {
        return $this->getHttpmethod() === 'get';
    }

    /**
     * Check if Http is post Request
     * ==================================================================================
     * @return boolean
     */
    public function isPost() : bool
    {
        return $this->getHttpmethod() === 'post';
    }

    /**
     * Add slashes
     * ==================================================================================
     * @param mixed $data
     * @return string
     */
    public function add_slashes(mixed $data) : string
    {
        return addslashes($data);
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
}