<?php
declare(strict_types=1);

class Globals extends GlobalsManager
{
    /**
     * Get $_GET
     * =================================================================================
     * @param string $key
     * @return mixed
     */
    public function getGet(string $key = null) : mixed
    {
        $get = filter_input_array(INPUT_GET) ?? null;
        if (null != $key) {
            return $get[$key] ?? null;
        }
        return array_map('strip_tags', $get ?? []);
    }

    /**
     * Get $_POST
     * =================================================================================
     * @param string $key
     * @return mixed
     */
    public function getPost(string $key = null) : mixed
    {
        $post = filter_input_array(INPUT_POST) ?? null;
        if (null != $key) {
            return $post[$key] ?? null;
        }
        return array_map('strip_tags', $post ?? []);
    }

    /**
     * Get $_Cookies
     * =================================================================================
     * @param string $key
     * @return mixed
     */
    public function getCookie(string $key = null) : mixed
    {
        $cookie = filter_input_array(INPUT_COOKIE) ?? null;
        if (null != $key) {
            return $cookie[$key] ?? null;
        }
        return array_map('strip_tags', $cookie ?? []);
    }
}