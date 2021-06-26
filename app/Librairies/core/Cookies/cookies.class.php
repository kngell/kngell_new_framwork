<?php

class Cookies
{
	//=======================================================================
	//Ckeckers
	//=======================================================================

	public static function exists($name)
	{
		return isset($_COOKIE[$name]);
	}

	//=======================================================================
	//Setters
	//=======================================================================
	public static function set($name, $value, $expiry)
	{
		if (setcookie($name, $value, time() + $expiry, '/', 'kngell.com', true, true)) {
			return true;
		} else {
			return false;
		}
	}

	//=======================================================================
	//Getters
	//=======================================================================
	public static function get($name)
	{
		return $_COOKIE[$name];
	}

	//=======================================================================
	//Operations
	//=======================================================================

	public static function delete($name)
	{
		self::set($name, '', time() - 1);
	}
}
