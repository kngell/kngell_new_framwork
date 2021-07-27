<?php
declare(strict_types=1);
class ModelHelper
{
    /**
     * Array search key and return key =>values
     * ============================================================================
     * @param string $search
     * @param array $values
     * @param integer $i
     * @return mixed
     */
    public static function array_search_recursive(string $search, array $values = [], int $i = 0) : mixed
    {
        $match = false;
        $i++;
        foreach ($values as $keyState => $val) {
            if ($keyState == $search) {
                return [$keyState => $val];
            }
            if (is_array($val)) {
                $match = self::array_search_recursive($search, $val, $i);
            }
            if ($match !== false) {
                return $match;
            }
        }

        return false;
    }

    public static function get_params_args(array $params)
    {
        if (!empty($params)) {
            if (array_key_exists('order_by', $params)) {
                $order_by = $params['order_by'];
            }
            if (array_key_exists('limit', $params)) {
                $limit = $params['limit'];
            }
        }
        return array_merge($group_by ?? [], $order_by ?? [], $limit ?? []);
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