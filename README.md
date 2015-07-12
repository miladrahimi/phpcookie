# PHPCookie
Free PHP cookie tools for neat and powerful projects!


## Documentation
PHPCookie is a tiny package for working with cookies and encrypting them.
It implemented the easy way to access and manipulating cookies with assuming security issues.
This package uses [PHPCrypt](https://github.com/miladrahimi/phpcrypt) package for encryption.

### Installation
#### Using Composer
It's strongly recommended to use [Composer](http://getcomposer.org).
If you are not familiar with Composer, The article
[How to use composer in php projects](http://miladrahimi.com/blog/2015/04/12/how-to-use-composer-in-php-projects)
can be useful.
After installing Composer, go to your project root directory and run following command there:
```
php composer.phar require miladrahimi/phpcrypt
```
Windows:
```
composer require miladrahimi/phpcookie
```
Or if you have `composer.json` file already in your application,
you may add this package to your application requirements
and update your dependencies:
```
"require": {
    "miladrahimi/phpcookie": "~1.0"
}
```
```
php composer.phar update
```
Windows:
```
composer update
```
#### Manually
You can use your own autoloader as long as it follows [PSR-0](http://www.php-fig.org/psr/psr-0) or
[PSR-4](http://www.php-fig.org/psr/psr-4) standards.
In this case you can put `src` directory content in your vendor directory.

### Getting Started
It's so easy to use!
It uses [PHPCrypt](https://github.com/miladrahimi/phpcrypt) package to encrypt and decrypt data.
So if you use Composer everything will be ok otherwise you must download this package too.
After installation of this package you must inject it to Cookie class.
See the example to grasp all what you need to know:

```
use MiladRahimi\PHPCookie\Cookie;
use MiladRahimi\PHPCrypt\Crypt;

$project_key = "3303a3f4640d601566c02cb8fe16d96e";

$crypt = new Crypt();
$crypt->setKey($project_key);

$cookie = new Cookie();
$cookie->setCrypt($crypt);

$cookie->set("Singer", "Pink Floyd");
```

*   First of all, you must set your project key to the instance of `Crypt` class.
*   Second of all, you must inject Crypt object to `Cookie` class via `Cookie::setCrypt()` method.
*   You can use `Cookie::set()` and `Cookie::get()` to set and get data in cookies.
*   The `Cookie::set()` parameters matches with native PHP `setCookie` function.

### Getting data from cookies
There is `get()` method in `Cookie` class which you can use to get data from cookie.
```
echo $cookie->get("Singer");
```

### Encryption
All cookies will be encrypted.
If you set cookie via this package, you have to use this package to get it too.

### PHPCookieException
There are some situation which PHPCookieException will be thrown.
Here are methods and messages:
*   `Crypt object is not set` in `Cookie::set()` when you use this method before injecting Crypt instance to the class.
*   `Crypt object is not set` in `Cookie::get()` when you use this method before injecting Crypt instance to the class.
*   `The cookie value not exists` in `Cookie::get()` when you trying to get some cookie value which not exists.

## Contributors
*	[Milad Rahimi](http://miladrahimi.com)

## Official homepage
*   [PHPCookie](http://miladrahimi.github.io/phpcookie)

## License
PHPCookie is released under the [MIT License](http://opensource.org/licenses/mit-license.php).
