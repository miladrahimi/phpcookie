<?php namespace MiladRahimi\PHPCookie;

use MiladRahimi\PHPCrypt\Crypt;
use MiladRahimi\PHPCrypt\CryptInterface;

/**
 * Class Cookie
 * Crypt class is the main package class.
 * This class is static and manipulates cookies
 *
 * @package MiladRahimi\PHPRouter
 * @author Milad Rahimi <info@miladrahimi.com>
 */
class Cookie
{
    /**
     * Crypt object to encrypt cookie data
     *
     * @var Crypt
     */
    private $crypt;

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
    public function set($name, $value, $expire = null, $path = null, $domain = null, $secure = null,
                        $httponly = null)
    {
        if (!isset($name) || !is_scalar($name))
            throw new InvalidArgumentException("Name must be a scalar|string value");
        if (!isset($value))
            throw new InvalidArgumentException("Value must be set");
        if (!is_null($expire) && !is_int($expire))
            throw new InvalidArgumentException("Expire must be a number");
        if (!is_null($path) && !is_scalar($path) && !method_exists($path, "__toString"))
            throw new InvalidArgumentException("Path must be a string value");
        if (!is_null($domain) && !is_scalar($domain) && !method_exists($domain, "__toString"))
            throw new InvalidArgumentException("Domain must be a string value");
        if (!is_null($secure) && !is_bool($secure))
            throw new InvalidArgumentException("Secure must be a boolean value");
        if (!is_null($httponly) && !is_bool($httponly))
            throw new InvalidArgumentException("HttpOnly must be a boolean value");
        if (!isset($this->crypt))
            throw new PHPCookieException("Crypt object is not set");
        $value = $this->crypt->encrypt($value);
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
    public function get($name)
    {
        if (!isset($name) || !is_scalar($name))
            throw new InvalidArgumentException("Name must be a scalar|string value");
        if (!isset($_COOKIE[$name]))
            throw new PHPCookieException("The cookie value not exists");
        if (!isset($this->crypt))
            throw new PHPCookieException("Crypt object is not set");
        return $this->crypt->decrypt($_COOKIE[$name]);
    }

    /**
     * @return Crypt
     */
    public function getCrypt()
    {
        return $this->crypt;
    }

    /**
     * @param CryptInterface $crypt
     */
    public function setCrypt(CryptInterface $crypt)
    {
        $this->crypt = $crypt;
    }

}