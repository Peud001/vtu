<?php

namespace App\Core;

class Route
{
    public static $routes = [];

    //route handler
    public static function routeHandler($uri, $controlArgs, $method)
    {
        if (preg_match_all('/\{[a-zA-Z0-9-_@]+\}/', $uri, $matches)) {
            $uri2 = preg_replace('/\{[a-zA-Z0-9-_@]+\}/', '([a-zA-Z0-9-_@]+)', $uri);
            $uri2 = str_replace('/', '\/', $uri2);
            $uri2 = '/^' . $uri2 . '$/';
        } else {
            $uri2 = $uri;
            $matches = false;
        }
        self::$routes[] = [
            'uri' => $uri,
            'preg' => $uri2,
            'matches' => $matches,
            'controlArgs' => $controlArgs,
            'method' => $method
        ];
    }
    //validate url
    public static function validateUrl($uri, $controlArgs)
    {

        //check if uri has parameters
        if(preg_match_all('/\{[a-zA-Z0-9-_@]+\}/', $uri, $matches))
        {
            //convert to dynamic regex
            $uri2 = preg_replace('/\{[a-zA-Z0-9-_@]+\}/', '([a-zA-Z0-9-_@]+)', $uri);
            //escape
            $uri2 = str_replace('/', '\/', $uri2);
            //add start and end
            $uri2 = '/^'.$uri2.'$/';
            //pass as a variable
            $matches_data = [];            
            // //loop through matches
            foreach($matches[0] as $match){
                $match = str_replace(['{', '}'], '', $match);
                $matches_data[$match] = null;
            }
            if (preg_match($uri2, Request::uri(), $matches)){
                if(class_exists($controlArgs[0])){
                    if(method_exists($controlArgs[0], $controlArgs[1])){
                        array_shift($matches);
                        $matches = array_combine(array_keys(($matches_data)), $matches);
                    }
                    $controller = new $controlArgs[0];
                    $controller->{$controlArgs[1]}(
                        new Request,
                        $matches
                    );
                }
            } else {
                return false;
            }
        }else{
            self::classNotFound([$controlArgs[0]]);
            return false;
        }
    }
    //get
    public static function get($uri, $controlArgs)
    {
        self::routeHandler($uri, $controlArgs, 'GET');
    }
    //post
    public static function post($uri, $controlArgs)
    {
        self::routeHandler($uri, $controlArgs, 'POST');
    }
    //put
    public static function put($uri, $controlArgs)
    {
        self::routeHandler($uri, $controlArgs, 'PUT');
    }
    //DELETE 
    public function delete($uri, $controlArgs)
    {
        self::routeHandler($uri, $controlArgs, 'DELETE');
    }
    //any
    public static function any($uri, $controlArgs)
    {
        self::routeHandler($uri, $controlArgs, 'ANY');
    }
    //not found
    public static function notFound()
    {
        echo 404;
    }
    //404 header
    public static function notFoundHeader()
    {
        echo 'Header Not Found';
        exit;
    }
    //class not found
    public static function classNotFound($class)
    {
        echo "'$class' not found";
    }
    //run
    public static function run()
    {
        //check if route is empty
        if (empty(self::$routes)) {
            self::notFound();
            return;
        }
        //current method
        $method = Request::method();
        $uri = Request::uri();
        //page not found
        $pageNotFound = [];
        //loop through routes
        foreach (self::$routes as $route) {
            //check if matches is not false
            if ($route['matches'] !== false) {
                //check if uri matches preg
                if (preg_match($route['preg'], $uri, $matches)) {
                    if ($route['method'] == $method || $route['method'] == "ANY") {
                        //Do a validation
                        $validate = self::validateUrl($route['uri'], $route['controlArgs']);
                        echo '<pre>';
                        var_dump($validate);
                        echo '</pre>';
                    } else {
                        self::notFoundHeader();
                    }
                    //page not found
                    $pageNotFound[] = false;
                } else {
                    $pageNotFound[] = true;
                    //continue loop;
                    continue;
                }
            } else {
                //check if url matches
                if ($route['uri'] == $uri) {
                    //check if method matches
                    if ($route['method'] == $method || $route['method'] == "ANY") {
                        //do validation
                    } else {
                        self::notFoundHeader();
                    }
                    //page found
                    $pageNotFound[] = false;
                } else {
                    $pageNotFound[] = true;
                    //continue loop
                    continue;
                }
            }
        }
    }
}
