<?php

namespace Lernfeld1011\infrastructure;

/** Our Basic Router that checks if the path is an allowed Route */
class Router
{
    /** @var array all routes. Each route has expression, function, method */
    private static $routes = [];

    /** @var null callable function */
    private static $pathNotFound = null;

    /** @var null callable function */
    private static $methodNotAllowed = null;

    public static function add($expression, $function, $method = 'get'): void
    {
        // adds a Route. Expression is the path. function is the called function and method is post or get
        self::$routes[] = [
            'expression' => $expression,
            'function' => $function,
            'method' => $method,
        ];
    }

    /** assign a function as $pathNotFound */
    public static function pathNotFound($function): void
    {
        self::$pathNotFound = $function;
    }

    /** assign a function as $methodNotAllowed */
    public static function methodNotAllowed($function): void
    {
        self::$methodNotAllowed = $function;
    }

    public static function run($basepath = '/'): void
    {
        // Initialize properties, no path or route found yet
        $path = '/';
        $pathMatchFound = false;
        $routeMatchFound = false;

        // extracts the url
        $parsedUrl = parse_url($_SERVER['REQUEST_URI']);
        // extracts the path
        if (isset($parsedUrl['path'])) {
            $path = $parsedUrl['path'];
        }

        // extracts used http-method (post,get,...)
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        // cycle through all added Routes
        foreach (self::$routes as $route) {
            // Add basepath to matching string
            if ($basepath != '' && $basepath != '/') {
                // extends expression, if basepath is not empty
                $route['expression'] = '('.$basepath.')'.$route['expression'];
            }

            //RegEx
            //find string start
            $route['expression'] = '^'.$route['expression'];
            //find string end
            $route['expression'] = $route['expression'].'$';
            // ^routeExpression$
            // Check path match. Use # as delimeter. Stores matches in $matches
            if (preg_match('#'.$route['expression'].'#', $path, $matches)) {
                $pathMatchFound = true;
                //check method match
                if (strtolower($httpMethod) == strtolower($route['method'])) {
                    array_shift($matches); //always remove first element. This contains whole string

                    if ($basepath != '' && $basepath != '/') {
                        array_shift($matches); //remove basepath
                        // matches contains only the relevant information
                        // bsp: Path: /api/v1/controllername/method/parameter1/parameter2/parameter3
                        // after double array_shift $matches should look like: [2 => controllername,  3 => method,
                        //  4 => parameter1, 5 => parameter2, 6 => parameter3]
                    }
                    // call the defined function with all the matches as array
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
