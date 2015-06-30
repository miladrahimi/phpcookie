<?php namespace Neatplex\PHPCookie;

use Neatplex\PHPCrypt\Crypt;

/**
 * Class Cookie
 *
 * Crypt class is the main package class.
 * This class is static and manipulates cookies
 *
 * @package Neatplex\PHPRouter
 *
 * @author Milad Rahimi <info@miladrahimi.com>
 */
class Cookie
{
    /**
     * Crypt object to encrypt cookie data
     *
     * @var Crypt
     */
    private static $crypt;

    /**
     * @return Crypt
     */
    public static function getCrypt()
    {
        return self::$crypt;
    }

    /**
     * Set Crypt object
     *
     * @param Crypt $crypt
     * @throws InvalidArgumentException
     */
    public static function setCrypt($crypt)
    {
        if (!isset($crypt) || !$crypt instanceof Crypt)
            throw new InvalidArgumentException("Crypt must be instance of Neatplex\\PHPCrypt\\Crypt class");
        self::$crypt = $crypt;
    }

    /**
     * Set new cookie value
     *
     * @param string $name
     * @param string|null $value
     * @param int|null $expire
     * @param string|null $path
     * @param string|null $domain
     * @param bool|null $secure
     * @param bool|null $httponly
     * @return bool
     * @throws InvalidArgumentException
     * @throws PHPCookieException
     */
    public static function set($name, $value, $expire = null, $path = null, $domain = null, $secure = null,
                               $httponly = null)
    {
        if (!isset($name) && !is_scalar($name) && !method_exists($name, "__toString"))
            throw new InvalidArgumentException("Name must be a scalar|string value");
        if (!isset($value))
            throw new InvalidArgumentException("Value must be set");
        if (!isset($expire) && !is_null($expire) && !is_int($expire))
            throw new InvalidArgumentException("Expire must be a number");
        if (!isset($path) && !is_null($path) && !is_scalar($path) && !method_exists($path, "__toString"))
            throw new InvalidArgumentException("Path must be a string value");
        if (!isset($domain) && !is_null($domain) && !is_scalar($domain) && !method_exists($domain, "__toString"))
            throw new InvalidArgumentException("Domain must be a string value");
        if (!isset($secure) && !is_null($secure) && !is_bool($secure))
            throw new InvalidArgumentException("Secure must be a boolean value");
        if (!isset($httponly) && !is_null($httponly) && !is_bool($httponly))
            throw new InvalidArgumentException("HttpOnly must be a boolean value");
        if (!isset(self::$crypt))
            throw new PHPCookieException("Crypt object is not set");
        $value = self::$crypt->encrypt($value);
        return setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }

    /**
     * Get cookie value
     *
     * @param string $name
     * @return mixed
     * @throws InvalidArgumentException
     * @throws PHPCookieException
     */
    public static function get($name)
    {
        if (!isset($name) || (!is_scalar($name) && !method_exists($name, "__toString")))
            throw new InvalidArgumentException("Name must be a scalar|string value");
        if (!isset($_COOKIE[$name]))
            throw new PHPCookieException("The cookie value not exists");
        if (!isset(self::$crypt))
            throw new PHPCookieException("Crypt object is not set");
        return self::$crypt->decrypt($_COOKIE[$name]);
    }


}