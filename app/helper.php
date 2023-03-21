<?php


use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Psr\Http\Message\UploadedFileInterface;

if (!function_exists('passwordValidator')) {
    function passwordValidator($password){
        // Validate password strength
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            return false;
        }else{
            return true;
        }
    }
}

if (!function_exists('env')) {
    function env($key, $default = false)
    {
        $value = getenv($key);

        throw_when(
            !$value and !$default,
            "{$key} is not a define .env variable and has no default value"
        );

        return $value or $default;
    }

}

if (!function_exists('base_path')) {
    function base_path($path = '')
    {
        return __DIR__ . "/../{$path}";
    }
}

if (!function_exists('config_path')) {
    function config_path($path = '')
    {
        return base_path("config/{$path}");
    }
}

if (!function_exists('cache_path')) {
    function cache_path($path = '')
    {
        return base_path("cache/{$path}");
    }
}

if (!function_exists('database_path')) {
    function database_path($path = '')
    {
        return base_path("database/{$path}");
    }
}

if (!function_exists('storage_path')) {
    function storage_path($path = '')
    {
        return base_path("storage/{$path}");
    }
}

if (!function_exists('public_path')) {
    function public_path($path = '')
    {
        return base_path("public_path/{$path}");
    }
}

if (!function_exists('resources_path')) {
    function resources_path($path = '')
    {
        return base_path("resources/{$path}");
    }
}

if (!function_exists('routes_path')) {
    function routes_path($path = '')
    {
        return base_path("routes/{$path}");
    }
}

if (!function_exists('app_path')) {
    function app_path($path = '')
    {
        return base_path("app/{$path}");
    }
}

if (!function_exists('bootstrap_path')) {
    function bootstrap_path($path = '')
    {
        return base_path("bootstrap/{$path}");
    }
}

if (!function_exists('dd')) {
    function dd()
    {
        array_map(function ($content) {
            echo "<pre>";
            var_dump($content);
            echo "</pre>";
            echo "<hr>";
        }, func_get_args());

        die;
    }
}

if (!function_exists('throw_when')) {
    function throw_when(bool $fails, string $message, string $exception = Exception::class)
    {
        if (!$fails) {
            return;
        }

        throw new $exception($message);
    }
}

if (!function_exists('class_basename')) {
    function class_basename($class)
    {
        $class = is_object($class) ? get_class($class) : $class;

        return basename(str_replace('\\', '/', $class));
    }
}

if (!function_exists('config')) {
    function config($path = null)
    {
        $config = [];
        $folder = scandir(config_path());
        $config_files = array_slice($folder, 2, count($folder));

        foreach ($config_files as $file) {
            throw_when(
                Str::after($file, '.') !== 'php',
                'Config files must be .php files'
            );


            data_set($config, Str::before($file, '.php'), require config_path($file));
        }

        return data_get($config, $path);
    }
}

if (!function_exists('data_get')) {
    /**
     * Get an item from an array or object using "dot" notation.
     *
     * @param mixed $target
     * @param string|array|int|null $key
     * @param mixed $default
     * @return mixed
     */
    function data_get($target, $key, $default = null)
    {
        if (is_null($key)) {
            return $target;
        }

        $key = is_array($key) ? $key : explode('.', $key);

        while (!is_null($segment = array_shift($key))) {
            if ($segment === '*') {
                if ($target instanceof Collection) {
                    $target = $target->all();
                } elseif (!is_array($target)) {
                    return value($default);
                }

                $result = [];

                foreach ($target as $item) {
                    $result[] = data_get($item, $key);
                }

                return in_array('*', $key) ? Arr::collapse($result) : $result;
            }

            if (Arr::accessible($target) && Arr::exists($target, $segment)) {
                $target = $target[$segment];
            } elseif (is_object($target) && isset($target->{$segment})) {
                $target = $target->{$segment};
            } else {
                return value($default);
            }
        }

        return $target;
    }
}
if (!function_exists('http_request')) {
    /**
     * @param $url
     * @param $payload
     * @param array $headers
     * @param string $requestMethod
     * @return bool|string
     */
    function http_request($url, $payload, $headers = [], $requestMethod = 'GET')
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        //curl_setopt($ch, CURLOPT_PROXY, $_ENV['PROXY_PORT']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $requestMethod);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload ?: '');

        $result = curl_exec($ch);

        if ($result === false) {
            curl_close($ch);
            return false;
        }
        curl_close($ch);

        return $result;
    }
}

if (!function_exists('get_ip')) {
    function get_ip()
    {
        //whether ip is from the share internet
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } //whether ip is from the proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } //whether ip is from the remote address
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}

if (!function_exists('data_set')) {
    /**
     * Set an item on an array or object using dot notation.
     *
     * @param mixed $target
     * @param string|array $key
     * @param mixed $value
     * @param bool $overwrite
     * @return mixed
     */
    function data_set(&$target, $key, $value, $overwrite = true)
    {
        $segments = is_array($key) ? $key : explode('.', $key);

        if (($segment = array_shift($segments)) === '*') {
            if (!Arr::accessible($target)) {
                $target = [];
            }

            if ($segments) {
                foreach ($target as &$inner) {
                    data_set($inner, $segments, $value, $overwrite);
                }
            } elseif ($overwrite) {
                foreach ($target as &$inner) {
                    $inner = $value;
                }
            }
        } elseif (Arr::accessible($target)) {
            if ($segments) {
                if (!Arr::exists($target, $segment)) {
                    $target[$segment] = [];
                }

                data_set($target[$segment], $segments, $value, $overwrite);
            } elseif ($overwrite || !Arr::exists($target, $segment)) {
                $target[$segment] = $value;
            }
        } elseif (is_object($target)) {
            if ($segments) {
                if (!isset($target->{$segment})) {
                    $target->{$segment} = [];
                }

                data_set($target->{$segment}, $segments, $value, $overwrite);
            } elseif ($overwrite || !isset($target->{$segment})) {
                $target->{$segment} = $value;
            }
        } else {
            $target = [];

            if ($segments) {
                data_set($target[$segment], $segments, $value, $overwrite);
            } elseif ($overwrite) {
                $target[$segment] = $value;
            }
        }

        return $target;
    }
}