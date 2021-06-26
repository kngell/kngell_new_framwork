<?php
class Sessionxx
{
    public static function exists($name)
    {
        return (isset($_SESSION[$name])) ? true : false;
    }

    public static function get($name)
    {
        return $_SESSION[$name];
    }

    public static function set($name, $value)
    {
        return $_SESSION[$name] = $value;
    }

    public static function delete($name)
    {
        if (self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    public static function destroy()
    {
        session_unset();
        session_destroy();
    }

    public static function uagent_no_version()
    {
        $uagent = $_SERVER['HTTP_USER_AGENT'];
        $regx = '/\/[a-zA-z0-9.]+/';
        $newString = preg_replace($regx, '', $uagent);
        return $newString;
    }

    public static function flash($name, $string = '')
    {
        if (self::exists($name)) {
            $session = self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::set($name, $string);
        }
    }

    public static function set_redirect($controller, $method)
    {
        $redirect_file = file_get_contents(APP . 'redirect.json');
        $redirect = json_decode($redirect_file, true);
        if (!self::exists(REDIRECT)) {
            foreach ($redirect as $ctrl => $mth) {
                if ($ctrl == $controller) {
                    if (in_array($method, $redirect[$controller]) || in_array('*', $redirect[$controller])) {
                        self::set(REDIRECT, 'redirect');
                    }
                }
            }
        }
    }
}