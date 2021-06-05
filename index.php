<?php
require_once "./includes/routes.php";
if(file_exists ("./includes/bdd.php"))
{
    include_once "./includes/bdd.php";
}

//mode Debug
error_reporting(E_ALL);
ini_set('display_errors', '1');

//Allow CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: origin, x-requested-with, content-type");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");

// Ouverture session
session_start();
$routeTrouve = false;
foreach($routes as $route)
{
  /*  echo '<pre>';
    var_dump($route);
    var_dump($_GET);
    echo '</pre>';*/
    if((!isset($_GET["controller"]) && $route["controller"]==="") || (isset($_GET["controller"]) && $_GET["controller"]===$route["controller"]))
    {
        if((!isset($_GET["action"]) && $route["action"]==="") || (isset($_GET["action"]) && $_GET["action"]===$route["action"]))
        {
            $routeTrouve=true;
            require_once $route["fichierController"];
            $monCont = new $route["classController"]();
            $f =$route["funcController"];
            $monCont->$f(($route["param"])?$_GET['id']:"");
            //($route["param"])?$_GET['id']:""
        }
       
    }
    
}
if(!$routeTrouve)
{
    echo 'route non géré';
}
