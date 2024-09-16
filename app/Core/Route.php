<?php
namespace App\Core;

class Route
{
    public static $routes = [];

    //route handler
    public static function routeHandler($uri, $controlArgs, $method)
    {
        self::$routes[] = [
            'uri' => $uri,
            'controlArgs' => $controlArgs,
            'method' => $method
        ];
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
    public static function set404Header()
    {
        echo '404 Not Found';
    }
    //class not found
    public static function classNotFound($class)
    {
        echo "'$class' not found";
    }
    //run
    public static function run()
    {
        echo '<pre>';
        var_dump(self::$routes);
        '</pre>';
    }
}