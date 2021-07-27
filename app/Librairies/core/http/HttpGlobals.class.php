<?php
declare(strict_types=1);

abstract class HttpGlobals implements HttpInterface
{
    /**
     * Get $_GET
     * =================================================================================
     * @param string $key
     * @return mixed
     */
    public function getGet(string $key = null) : mixed
    {
        $global = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
        if (null != $key) {
            return $global[$key] ?? null;
        }
        return array_map('strip_tags', $global ?? []);
    }

    /**
     * Get $_POST
     * =================================================================================
     * @param string $key
     * @return mixed
     */
    public function getPost(string $key = null) : mixed
    {
        $global = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
        if (null != $key) {
            return $post[$key] ?? null;
        }
        return array_map('strip_tags', $global ?? []);
    }

    /**
     * Get $_Cookies
     * =================================================================================
     * @param string $key
     * @return mixed
     */
    public function getCookie(string $key = null) : mixed
    {
        $global = filter_input_array(INPUT_COOKIE, FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
        if (null != $key) {
            return $global[$key] ?? null;
        }
        return array_map('strip_tags', $global ?? []);
    }

    /**
         * Get $_Cookies
         * =================================================================================
         * @param string $key
         * @return mixed
         */
    public function getServer(string $key = null) : mixed
    {
        $global = filter_input_array(INPUT_SERVER, FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
        if (null != $key) {
            return $global[$key] ?? '/';
        }
        return array_map('strip_tags', $global ?? []);
    }
}