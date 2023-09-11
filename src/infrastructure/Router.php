<?php

namespace Lernfeld1011\infrastructure;

class Router
{
    private static $routes = [];

    private static $pathNotFound = null;

    private static $methodNotAllowed = null;

    public static function add($expression, $function, $method = 'get'): void
    {
        self::$routes[] = [
            'expression' => $expression,
            'function' => $function,
            'method' => $method,
        ];
    }

    public static function pathNotFound($function): void
    {
        self::$pathNotFound = $function;
    }

    public static function methodNotAllowed($function): void
    {
        self::$methodNotAllowed = $function;
    }

    public static function run($basepath = '/'): void
    {
        $path = '/';
        $pathMatchFound = false;
        $routeMatchFound = false;

        $parsedUrl = parse_url($_SERVER['REQUEST_URI']);
        if (isset($parsedUrl['path'])) {
            $path = $parsedUrl['path'];
        }

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        foreach (self::$routes as $route) {
            // Add basepath to matching string
            if ($basepath != '' && $basepath != '/') {
                $route['expression'] = '('.$basepath.')'.$route['expression'];
            }

            //RegEx
            //find string start
            $route['expression'] = '^'.$route['expression'];
            //find string end
            $route['expression'] = $route['expression'].'$';

            //Check path match
            if (preg_match('#'.$route['expression'].'#', $path, $matches)) {
                $pathMatchFound = true;
                //check method match
                if (strtolower($httpMethod) == strtolower($route['method'])) {
                    array_shift($matches); //always remove first element. This contains whole string

                    if ($basepath != '' && $basepath != '/') {
                        array_shift($matches); //remove basepath
                    }
                    call_user_func_array($route['function'], $matches);
                    $routeMatchFound = true;
                    //do not check other routes
                    break;
                }
            }
        }
        //route missed
        if (! $routeMatchFound) {
            if (! $pathMatchFound) {
                header('HTTP/1.0 405 Method not allowed');
                if (self::$methodNotAllowed) {
                    call_user_func_array(self::$methodNotAllowed, [$path, $httpMethod]);
                }
            } else {
                header('HTTP/1.0 404 Not found');
                if (self::$pathNotFound) {
                    call_user_func_array(self::$pathNotFound, [$path]);
                }
            }
        }
    }
}
