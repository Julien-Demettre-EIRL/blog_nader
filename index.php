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
/*if (!isset($_GET["controller"]) || $_GET["controller"] == "post") {
    if (!isset($_GET["action"]) || $_GET["action"] == "getArticles" || $_GET["action"] == "") {
        require_once './controller/posts.controller.php';
        $postController = new PostsController();
        $postController->getArticles();
    } elseif ($_GET["action"] == "getAjoutArticle") {
        if (!empty($_GET["id"])) {
            require_once './controller/posts.controller.php';
            $postController = new PostsController();
            $postController->getAjoutArticle((int) $_GET["id"]);
        }
    } elseif ($_GET["action"] == "suppArticle") {
        if (!empty($_GET["id"])) {
            require_once './controller/posts.controller.php';
            $postController = new PostsController();
            $postController->delArticle((int) $_GET["id"]);
        }
    } else {
        echo 'route inexistante';
    }

} elseif ($_GET["controller"] == "user") {
    if (!isset($_GET["action"]) || $_GET["action"] == "connect" || $_GET["action"] == "") {
        echo 'route non géré';
    } else {
        echo 'route inexistante';
    }
} elseif ($_GET["controller"] == "dashboard") {
    echo 'route non géré';
} else {
    echo 'route inexistante';
}
*/