<?php

session_start();

function __autoload($include)
{
    $conPath = str_replace('\\', '/', $include . ".php");
    if (file_exists($conPath)) {
        include_once $conPath;
    }
}
include_once "System/Functions.php";
$url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : "/";

$urlArr = explode("?",$url);
if(count($urlArr) > 2) {
    showError("Invalid url", $url);
}

$url = $urlArr[0];

$url = ltrim(rtrim($url,'/'),'/');

$registeredRoutes = include_once "Setting/Router.php";

foreach ($registeredRoutes as $routePath => $routeName) {

    $routePath = ltrim(rtrim($routePath,"/"),"/");
    $routes = include_once "/" . $routePath . "/".$routeName.".php";

    foreach ($routes as $routeURL=>$routeAction) {
        $routeURL = ltrim(rtrim($routeURL,'/'),'/');
        if($routeURL == $url) {

            $classPath = str_replace('/', '\\', "\\" . $routePath);

            $extract = explode("@", $routeAction);
            $controllerClass = $classPath."\\".$extract[0];
            $action = $extract[1];

            global $_GLOBAL_CLASS_PATH;

            $_GLOBAL_CLASS_PATH = $classPath;

            try {
                $controllerObject = new $controllerClass();
                return $controllerObject->{$action}();
            } catch (Throwable $exception) {
                echo $exception->getMessage();
                exit();
            }
        }
    }
}

showError("Either page route not found or not registered");



