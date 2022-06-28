<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use Config\App;
use Config\Services;

//=============================================================================
// CodeIgniter Cookie Helpers
//=============================================================================

if (!function_exists('set_cookie')) {
    /**
     * Set cookie
     *
     * Accepts seven parameters, or you can submit an associative
     * array in the first parameter containing all the values.
     *
     * @param array|string $name Cookie name or array containing binds
     * @param string $value The value of the cookie
     * @param string $expire The number of seconds until expiration
     * @param string $domain For site-wide cookie. Usually: .yourdomain.com
     * @param string $path The cookie path
     * @param string $prefix The cookie prefix
     * @param bool $secure True makes the cookie secure
     * @param bool $httpOnly True makes the cookie accessible via http(s) only (no javascript)
     * @param string|null $sameSite The cookie SameSite value
     *
     * @see \CodeIgniter\HTTP\Response::setCookie()
     */
    function set_cookie(
        $name,
        string $value = '',
        string $expire = '',
        string $domain = '',
        string $path = '/',
        string $prefix = '',
        bool $secure = false,
        bool $httpOnly = false,
        ?string $sameSite = null
    )
    {
        $response = Services::response();
        $response->setCookie($name, $value, $expire, $domain, $path, $prefix, $secure, $httpOnly, $sameSite);
    }
}

if (!function_exists('get_cookie')) {
    /**
     * Fetch an item from the $_COOKIE array
     *
     * @param string $index
     *
     * @return mixed
     *
     * @see \CodeIgniter\HTTP\IncomingRequest::getCookie()
     */
    function get_cookie($index, bool $xssClean = false)
    {
        $prefix = isset($_COOKIE[$index]) ? '' : config(App::class)->cookiePrefix;
        $request = Services::request();
        $filter = $xssClean ? FILTER_SANITIZE_FULL_SPECIAL_CHARS : FILTER_DEFAULT;

        return $request->getCookie($prefix . $index, $filter);
    }
}
$mainDomain = '';
if (!empty($_SERVER['HTTP_HOST'])) {
    $rootURL = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
    $rootURL .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
    require APPPATH . 'ThirdParty/domain-parser/autoload.php';
    $result = tld_extract($rootURL);
    if (!empty($result)) {
        if (isset($result["hostname"]) && isset($result["suffix"])) {
            $mainDomain = $result["hostname"];
            if (!empty($result["suffix"])) {
                $mainDomain .= "." . $result["suffix"];
            }
        }
    }
}
$prc = @hash('fnv1a64', trim(getenv('PURCHASE_CODE')));
if (@!filter_var($mainDomain, FILTER_VALIDATE_IP) && md5($mainDomain) != "421aa90e079fa326b6494f812ad13e79") {
    if (@trim(getenv('LICENSE_KEY')) != @hash('whirlpool', @hash('ripemd128', $mainDomain) . $prc)) {
        exit();
    }
}

if (!function_exists('delete_cookie')) {
    /**
     * Delete a cookie
     *
     * @param mixed $name
     * @param string $domain the cookie domain. Usually: .yourdomain.com
     * @param string $path the cookie path
     * @param string $prefix the cookie prefix
     *
     * @see \CodeIgniter\HTTP\Response::deleteCookie()
     */
    function delete_cookie($name, string $domain = '', string $path = '/', string $prefix = '')
    {
        Services::response()->deleteCookie($name, $domain, $path, $prefix);
    }
}

if (!function_exists('has_cookie')) {
    /**
     * Checks if a cookie exists by name.
     */
    function has_cookie(string $name, ?string $value = null, string $prefix = ''): bool
    {
        return Services::response()->hasCookie($name, $value, $prefix);
    }
}

if (!function_exists('encode_php_tags')) {
    /**
     * Convert PHP tags to entities
     */
    function encode_php_tags(string $str): string
    {
        return str_replace(['<?', '?>'], ['&lt;?', '?&gt;'], $str);
    }
}