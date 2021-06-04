<?php
//routes
$routes = [];
$routes["postGetAjout"] = [
    "lien"=>"./index.php?controller=post&action=getAjoutArticle&id=",
    "controller"=>"post",
    "action"=>"getAjoutArticle",
    "fichierController"=>'./controller/posts.controller.php',
    "classController"=>"PostsController",
    "funcController"=>"getAjoutArticle",
    "param"=>true
];
$routes["postGetArticle"] = [
    "lien"=>"./index.php",
    "controller"=>"",
    "action"=>"",
    "fichierController"=>'./controller/posts.controller.php',
    "classController"=>"PostsController",
    "funcController"=>"getArticles",
    "param"=>false
];
$routes["postSupArticle"] = [
    "lien"=>"./index.php?controller=post&action=supp&id=",
    "controller"=>"post",
    "action"=>"suppArticle",
    "fichierController"=>'./controller/posts.controller.php',
    "classController"=>"PostsController",
    "funcController"=>"delArticle",
    "param"=>true
];
$routes["postEditArticle"] = [
    "lien"=>"./index.php?controller=post&action=edit&id=",
    "controller"=>"post",
    "action"=>"edit",
    "fichierController"=>'./controller/posts.controller.php',
    "classController"=>"PostsController",
    "funcController"=>"editArticle",
    "param"=>true
];
$routes["postAjoutArticle"] = [
    "lien"=>"./index.php?controller=post&action=ajout",
    "controller"=>"post",
    "action"=>"ajout",
    "fichierController"=>'./controller/posts.controller.php',
    "classController"=>"PostsController",
    "funcController"=>"ajoutArticle",
    "param"=>false
];
$routes["postListeArticleRedac"] = [
    "lien"=>"./index.php?controller=post&action=getArticleRedacteur&id=",
    "controller"=>"post",
    "action"=>"getArticleRedacteur",
    "fichierController"=>'./controller/posts.controller.php',
    "classController"=>"PostsController",
    "funcController"=>"listeArticleRedacteur",
    "param"=>true
];
$routes["dashboard"] = [
    "lien"=>"./index.php?controller=dashboard",
    "controller"=>"dashboard",
    "action"=>"",
    "fichierController"=>'./controller/dashboard.controller.php',
    "classController"=>"DashboardController",
    "funcController"=>"afficheDashboard",
    "param"=>false
];
$routes["dashboardCarrousel"] = [
    "lien"=>"./index.php?controller=dashboard&action=carrousel",
    "controller"=>"dashboard",
    "action"=>"carrousel",
    "fichierController"=>'./controller/dashboard.controller.php',
    "classController"=>"DashboardController",
    "funcController"=>"afficheDashCarrousel",
    "param"=>false
];
$routes["dashboardComment"] = [
    "lien"=>"./index.php?controller=dashboard&action=comment",
    "controller"=>"dashboard",
    "action"=>"comment",
    "fichierController"=>'./controller/dashboard.controller.php',
    "classController"=>"DashboardController",
    "funcController"=>"afficheDashComment",
    "param"=>false
];
$routes["dashboardUser"] = [
    "lien"=>"./index.php?controller=dashboard&action=user",
    "controller"=>"dashboard",
    "action"=>"user",
    "fichierController"=>'./controller/dashboard.controller.php',
    "classController"=>"DashboardController",
    "funcController"=>"afficheDashUser",
    "param"=>false
];
$routes["userCon"] = [
    "lien"=>"./index.php?controller=user&action=connect",
    "controller"=>"user",
    "action"=>"connect",
    "fichierController"=>'./controller/users.controller.php',
    "classController"=>"UsersController",
    "funcController"=>"connexion",
    "param"=>false
];
$routes["userDeco"] = [
    "lien"=>"./index.php?controller=user&action=deconnect",
    "controller"=>"user",
    "action"=>"deconnect",
    "fichierController"=>'./controller/users.controller.php',
    "classController"=>"UsersController",
    "funcController"=>"deconnexion",
    "param"=>false
];
$routes["userAjout"] = [
    "lien"=>"./index.php?controller=user&action=ajout",
    "controller"=>"user",
    "action"=>"ajout",
    "fichierController"=>'./controller/users.controller.php',
    "classController"=>"UsersController",
    "funcController"=>"enregistrement",
    "param"=>false
];
$routes["commentValid"] = [
    "lien"=>"./index.php?controller=comment&action=valid",
    "controller"=>"comment",
    "action"=>"valid",
    "fichierController"=>'./controller/comments.controller.php',
    "classController"=>"CommentsController",
    "funcController"=>"valid",
    "param"=>true
];
$routes["commentSupp"] = [
    "lien"=>"./index.php?controller=comment&action=supp",
    "controller"=>"comment",
    "action"=>"supp",
    "fichierController"=>'./controller/comments.controller.php',
    "classController"=>"CommentsController",
    "funcController"=>"delete",
    "param"=>true
];
$routes["validInstall"] = [
    "lien"=>"./index.php?controller=post&action=finishInst",
    "controller"=>"post",
    "action"=>"finishInst",
    "fichierController"=>'./controller/posts.controller.php',
    "classController"=>"PostsController",
    "funcController"=>"endSetup",
    "param"=>false
];
?>