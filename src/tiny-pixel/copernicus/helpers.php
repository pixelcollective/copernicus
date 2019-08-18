<?php

namespace TinyPixel;

use Illuminate\Container\Container;
use Illuminate\Contracts\Broadcasting\Factory as BroadcastFactory;
use Illuminate\Contracts\Cookie\Factory as CookieFactory;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Support\Facades\Date;
use Illuminate\View\View;
use TinyPixel\Copernicus\Copernicus as Application;
use TinyPixel\Copernicus\Assets\Asset;
use TinyPixel\Copernicus\Assets\Manifest;

/**
 * Get the available container instance.
 *
 * @param  string $abstract
 * @param  array  $parameters
 * @return mixed|\TinyPixel\Copernicus\Copernicus
 *
 * @copyright Taylor Otwell
 * @license   https://github.com/laravel/framework/blob/v5.6.25/LICENSE.md MIT
 * @link      https://github.com/laravel/framework/blob/v5.6.25/src/Illuminate/Foundation/helpers.php#L106-L120
 */
function app($abstract = null, array $parameters = []) : Application
{
    if (is_null($abstract)) {
        return Application::getInstance();
    }

    return Application::getInstance()->make($abstract, $parameters);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param  array|string $key
 * @param  mixed        $default
 * @return mixed|\TinyPixel\Copernicus\Config
 *
 * @copyright Taylor Otwell
 * @license   https://github.com/laravel/framework/blob/v5.6.25/LICENSE.md MIT
 * @link      https://github.com/laravel/framework/blob/v5.6.25/src/Illuminate/Foundation/helpers.php#L262-L282
 */
function config($key = null, $default = null)
{
    if (is_null($key)) {
        return app('config');
    }

    if (is_array($key)) {
        return app('config')->set($key);
    }

    return app('config')->get($key, $default);
}

/**
 * Get asset from manifest
 *
 * @param  string $key Asset key, typically a relative path to the asset
 * @param  string $manifest Name of registered manifest
 * @return \TinyPixel\Copernicus\Assets\Asset
 */
function asset($key, $manifest = null)
{
    return app('assets')->manifest($manifest)->get($key);
}

/**
 * Get the evaluated view contents for the given view.
 *
 * @param  string $view      View name or file path
 * @param  array  $data
 * @param  array  $mergeData
 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.6.25/src/Illuminate/Foundation/helpers.php#L983-L1000
 */
function view($view = null, $data = [], $mergeData = [])
{
    /** @var \Illuminate\Contracts\View\Factory $factory */
    $factory = app('view');
    if (func_num_args() === 0) {
        return $factory;
    }

    return $factory->exists($view)
        ? $factory->make($view, $data, $mergeData)
        : $factory->file($view, $data, $mergeData);
}

/**
 * Resolve a service from the container.
 *
 * @param  string  $name
 * @param  array  $parameters
 * @return mixed
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L721-L731
 */
function resolve($name, array $parameters = [])
{
    return app($name, $parameters);
}

/**
 * Get / set the specified cache value.
 *
 * If an array is passed, we'll assume you want to put to the cache.
 *
 * @param  dynamic  key|key,default|data,expiration|null
 * @return mixed|\Illuminate\Cache\CacheManager
 *
 * @throws \Exception
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L225-L260
 */
function cache()
{
    $arguments = func_get_args();
    if (empty($arguments)) {
        return app('cache');
    }
    if (is_string($arguments[0])) {
        return app('cache')->get(...$arguments);
    }
    if (! is_array($arguments[0])) {
        throw new \Exception(
            'When setting a value in the cache, you must pass an array of key / value pairs.'
        );
    }
    if (! isset($arguments[1])) {
        throw new \Exception(
            'You must specify an expiration time when setting a value in the cache.'
        );
    }
    return app('cache')->put(key($arguments[0]), reset($arguments[0]), $arguments[1]);
}

/**
 * Create a new Validator instance.
 *
 * @param  array  $data
 * @param  array  $rules
 * @param  array  $messages
 * @param  array  $customAttributes
 * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Contracts\Validation\Factory
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L848-L857
 */
function validator(array $data = [], array $rules = [], array $messages = [], array $customAttributes = [])
{
    $factory = app(ValidationFactory::class);
    if (func_num_args() === 0) {
        return $factory;
    }
    return $factory->make($data, $rules, $messages, $customAttributes);
}

/**
 * Get the path to the application folder.
 *
 * @param  string  $path
 * @return string
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L126-L135
 */
function app_path($path = '')
{
    return app()->path($path);
}

/**
 * Get the path to the base of the install.
 *
 * @param  string  $path
 * @return string
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L185-L194
 */
function base_path($path = '')
{
    return app()->basePath() . ($path ? DIRECTORY_SEPARATOR . $path : $path);
}

/**
 * Get the configuration path.
 *
 * @param  string  $path
 * @return string
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L288-L297
 */
function config_path($path = '')
{
    return app()->configPath($path);
}

/**
 * Get the database path.
 *
 * @param  string  $path
 * @return string
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L360-L369
 */
function database_path($path = '')
{
    return app()->databasePath($path);
}

/**
 * Get the path to the public folder.
 *
 * @param  string  $path
 * @return string
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L626-L635
 */
function public_path($path = '')
{
    return app()->publicPath() . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : $path);
}

/**
 * Get the path to the resources folder.
 *
 * @param  string  $path
 * @return string
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L735-L744
 */
function resource_path($path = '')
{
    return app()->resourcePath($path);
}

/**
 * Get the path to the storage folder.
 *
 * @param  string  $path
 * @return string
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L835-L844
 */
function storage_path($path = '')
{
    return app()->storagePath() . ($path ? DIRECTORY_SEPARATOR . $path : $path);
}

/**
 * Hash the given value against the bcrypt algorithm.
 *
 * @param  string  $value
 * @param  array  $options
 * @return string
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L198-L208
 */
function bcrypt($value, $options = [])
{
    return app('hash')->driver('bcrypt')->make($value, $options);
}

/**
 * Decrypt the given value.
 *
 * @param  string  $value
 * @param  bool   $unserialize
 * @return mixed
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L373-L383
 */
function decrypt($value, $unserialize = true)
{
    return app('encrypter')->decrypt($value, $unserialize);
}

/**
 * Encrypt the given value.
 *
 * @param  mixed  $value
 * @param  bool   $serialize
 * @return string
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L458-L468
 */
function encrypt($value, $serialize = true)
{
    return app('encrypter')->encrypt($value, $serialize);
}

/**
 * Begin broadcasting an event.
 *
 * @param  mixed|null  $event
 * @return \Illuminate\Broadcasting\PendingBroadcast
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L212-L221
 */
function broadcast($event = null)
{
    return app(BroadcastFactory::class)->event($event);
}

/**
 * Write some information to the log.
 *
 * @param  string  $message
 * @param  array   $context
 * @return void
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L510-L520
 */
function info($message, $context = [])
{
    app('log')->info($message, $context);
}

/**
 * Log a debug message to the logs.
 *
 * @param  string  $message
 * @param  array  $context
 * @return \Illuminate\Log\LogManager|null
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L524-L538
 */
function logger($message = null, array $context = [])
{
    if (is_null($message)) {
        return app('log');
    }
    return app('log')->debug($message, $context);
}

/**
 * Report an exception.
 *
 * @param  \Throwable  $exception
 * @return void
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L659-L673
 */
function report($exception)
{
    if ($exception instanceof Throwable &&
        ! $exception instanceof Exception) {
        $exception = new FatalThrowableError($exception);
    }
    app(ExceptionHandler::class)->report($exception);
}

/**
 * Catch a potential exception and return a default value.
 *
 * @param  callable  $callback
 * @param  mixed  $rescue
 * @return mixed
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L701-L717
 */
function rescue(callable $callback, $rescue = null)
{
    try {
        return $callback();
    } catch (Throwable $e) {
        report($e);
        return value($rescue);
    }
}

/**
 * Get a log driver instance.
 *
 * @param  string  $driver
 * @return \Illuminate\Log\LogManager|\Psr\Log\LoggerInterface
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L542-L551
 */
function logs($driver = null)
{
    return $driver ? app('log')->driver($driver) : app('log');
}

/**
 * Create a new Carbon instance for the current time.
 *
 * @param  \DateTimeZone|string|null $tz
 * @return \Illuminate\Support\Carbon
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L584-L593
 */
function now($tz = null)
{
    return Date::now($tz);
}

/**
 * Create a new Carbon instance for the current date.
 *
 * @param  \DateTimeZone|string|null $tz
 * @return \Illuminate\Support\Carbon
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L848-L857
 */
function today($tz = null)
{
    return Date::today($tz);
}

/**
 * Create a new cookie instance.
 *
 * @param  string  $name
 * @param  string  $value
 * @param  int  $minutes
 * @param  string  $path
 * @param  string  $domain
 * @param  bool  $secure
 * @param  bool  $httpOnly
 * @param  bool  $raw
 * @param  string|null  $sameSite
 * @return \Illuminate\Cookie\CookieJar|\Symfony\Component\HttpFoundation\Cookie
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L301-L324
 */
function cookie(
    $name = null,
    $value = null,
    $minutes = 0,
    $path = null,
    $domain = null,
    $secure = false,
    $httpOnly = true,
    $raw = false,
    $sameSite = null
) {
    $cookie = app(CookieFactory::class);
    if (is_null($name)) {
        return $cookie;
    }
    return $cookie->make($name, $value, $minutes, $path, $domain, $secure, $httpOnly, $raw, $sameSite);
}

/**
 * Get / set the specified session value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param  array|string  $key
 * @param  mixed  $default
 * @return mixed|\Illuminate\Session\Store|\Illuminate\Session\SessionManager
 *
 * @copyright Taylor Otwell
 * @link      https://github.com/laravel/framework/blob/v5.8.17/src/Illuminate/Foundation/helpers.php#L811-L831
 */
function session($key = null, $default = null)
{
    if (is_null($key)) {
        return app('session');
    }
    if (is_array($key)) {
        return app('session')->put($key);
    }
    return app('session')->get($key, $default);
}

/**
 * Copernicus bootloader
 */
function bootloader($callback = null)
{
    static $bootloader;

    if (! $bootloader) {
        $bootloader = new \TinyPixel\Copernicus\Bootloader();
    }

    if (is_callable($callback)) {
        $bootloader->call($callback);
    }
}
