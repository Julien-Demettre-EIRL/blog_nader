<?php
//routes
$routes = [];

//route front office
$routes["postGetArticle"] = [ //page d'accueil
    "lien"=>"./index.php",
    "controller"=>"",
    "action"=>"",
    "fichierController"=>'./controller/posts.controller.php',
    "classController"=>"PostsController",
    "funcController"=>"getArticles",
    "param"=>false
];
$routes["postGetAjout"] = [ //page détail article
    "lien"=>"./index.php?controller=post&action=getAjoutArticle&id=",
    "controller"=>"post",
    "action"=>"getAjoutArticle",
    "fichierController"=>'./controller/posts.controller.php',
    "classController"=>"PostsController",
    "funcController"=>"getAjoutArticle",
    "param"=>true
];

$routes["postListeAllArticle"] = [    //Liste des articles par rédacteur
    "lien"=>"./index.php?controller=post&action=getAllArticle",
    "controller"=>"post",
    "action"=>"getAllArticle",
    "fichierController"=>'./controller/posts.controller.php',
    "classController"=>"PostsController",
    "funcController"=>"listeAllArticle",
    "param"=>false
];
$routes["userCon"] = [  //Connexion utilisateur
    "lien"=>"./index.php?controller=user&action=connect",
    "controller"=>"user",
    "action"=>"connect",
    "fichierController"=>'./controller/posts.controller.php',
    "classController"=>"PostsController",
    "funcController"=>"connexionUser",
    "param"=>false
];
$routes["validInstall"] = [ //Lancement de l'installe si pas de BDD /!\ non terminé /!\
    "lien"=>"./index.php?controller=post&action=finishInst",
    "controller"=>"post",
    "action"=>"finishInst",
    "fichierController"=>'./controller/posts.controller.php',
    "classController"=>"PostsController",
    "funcController"=>"endSetup",
    "param"=>false
];


//routes back office
$routes["dashboard"] = [    //Tableau de bord article
    "lien"=>"./index.php?controller=dashboard",
    "controller"=>"dashboard",
    "action"=>"",
    "fichierController"=>'./controller/dashboard.controller.php',
    "classController"=>"DashboardController",
    "funcController"=>"afficheDashboard",
    "param"=>false
];
$routes["postAjoutArticle"] = [ //Ajout article
    "lien"=>"./index.php?controller=post&action=ajout",
    "controller"=>"post",
    "action"=>"ajout",
    "fichierController"=>'./controller/dashboard.controller.php',
    "classController"=>"DashboardController",
    "funcController"=>"ajoutArticle",
    "param"=>false
];
$routes["postEditArticle"] = [  //Edition article
    "lien"=>"./index.php?controller=post&action=edit&id=",
    "controller"=>"post",
    "action"=>"edit",
    "fichierController"=>'./controller/dashboard.controller.php',
    "classController"=>"DashboardController",
    "funcController"=>"editArticle",
    "param"=>true
];
$routes["postSupArticle"] = [   //Suppression article
    "lien"=>"./index.php?controller=post&action=supp&id=",
    "controller"=>"post",
    "action"=>"supp",
    "fichierController"=>'./controller/dashboard.controller.php',
    "classController"=>"DashboardController",
    "funcController"=>"delArticle",
    "param"=>true
];

$routes["dashboardCarrousel"] = [ //Tableau de bord carrousel
    "lien"=>"./index.php?controller=dashboard&action=carrousel",
    "controller"=>"dashboard",
    "action"=>"carrousel",
    "fichierController"=>'./controller/dashboard.controller.php',
    "classController"=>"DashboardController",
    "funcController"=>"afficheDashCarrousel",
    "param"=>false
];
$routes["postAjoutImgCarrousel"] = [ //Ajout image carrousel
    "lien"=>"./index.php?controller=post&action=ajoutImg",
    "controller"=>"post",
    "action"=>"ajoutImg",
    "fichierController"=>'./controller/dashboard.controller.php',
    "classController"=>"DashboardController",
    "funcController"=>"ajoutImgCar",
    "param"=>false
];
$routes["postSupImgCarrousel"] = [ //Suppression image carrousel
    "lien"=>"./index.php?controller=post&action=suppImg&id=",
    "controller"=>"post",
    "action"=>"suppImg",
    "fichierController"=>'./controller/dashboard.controller.php',
    "classController"=>"DashboardController",
    "funcController"=>"delImgCar",
    "param"=>true
];

$routes["dashboardVideo"] = [    //Tableau de bord utilisateurs
    "lien"=>"./index.php?controller=dashboard&action=video",
    "controller"=>"dashboard",
    "action"=>"video",
    "fichierController"=>'./controller/dashboard.controller.php',
    "classController"=>"DashboardController",
    "funcController"=>"affVideo",
    "param"=>false
];
$routes["dashboardVideoUp"] = [    //Tableau de bord utilisateurs
    "lien"=>"./index.php?controller=dashboard&action=upVid",
    "controller"=>"dashboard",
    "action"=>"upVid",
    "fichierController"=>'./controller/dashboard.controller.php',
    "classController"=>"DashboardController",
    "funcController"=>"uploadVideo",
    "param"=>false
];
$routes["dashboardVideoIns"] = [    //Tableau de bord utilisateurs
    "lien"=>"./index.php?controller=dashboard&action=insVid",
    "controller"=>"dashboard",
    "action"=>"insVid",
    "fichierController"=>'./controller/dashboard.controller.php',
    "classController"=>"DashboardController",
    "funcController"=>"insertVideo",
    "param"=>false
];
$routes["dashboardVideoDel"] = [    //Tableau de bord utilisateurs
    "lien"=>"./index.php?controller=dashboard&action=delVid&id=",
    "controller"=>"dashboard",
    "action"=>"delVid",
    "fichierController"=>'./controller/dashboard.controller.php',
    "classController"=>"DashboardController",
    "funcController"=>"delVideo",
    "param"=>true
];
$routes["postAllVid"] = [    //Tableau de bord utilisateurs
    "lien"=>"./index.php?controller=post&action=allVid",
    "controller"=>"post",
    "action"=>"allVid",
    "fichierController"=>'./controller/posts.controller.php',
    "classController"=>"PostsController",
    "funcController"=>"allVid",
    "param"=>false
];
$routes["postDetVid"] = [    //Tableau de bord utilisateurs
    "lien"=>"./index.php?controller=post&action=detVid&id=",
    "controller"=>"post",
    "action"=>"detVid",
    "fichierController"=>'./controller/posts.controller.php',
    "classController"=>"PostsController",
    "funcController"=>"detVid",
    "param"=>true
];
$routes["postLectureVid"] = [    //Tableau de bord utilisateurs
    "lien"=>"./index.php?controller=post&action=lectVid&id=",
    "controller"=>"post",
    "action"=>"lectVid",
    "fichierController"=>'./controller/posts.controller.php',
    "classController"=>"PostsController",
    "funcController"=>"lireVideo",
    "param"=>true
];

$routes["dashboardUser"] = [    //Tableau de bord utilisateurs
    "lien"=>"./index.php?controller=dashboard&action=user",
    "controller"=>"dashboard",
    "action"=>"user",
    "fichierController"=>'./controller/dashboard.controller.php',
    "classController"=>"DashboardController",
    "funcController"=>"afficheDashUser",
    "param"=>false
];

$routes["dashboardUserdebloque"] = [    //Tableau de bord utilisateurs
    "lien"=>"./index.php?controller=dashboard&action=debloqueUser&id=",
    "controller"=>"dashboard",
    "action"=>"debloqueUser",
    "fichierController"=>'./controller/dashboard.controller.php',
    "classController"=>"DashboardController",
    "funcController"=>"debloqueUser",
    "param"=>true
];
$routes["dashboardUserDel"] = [    //Tableau de bord utilisateurs
    "lien"=>"./index.php?controller=dashboard&action=userDel&id=",
    "controller"=>"dashboard",
    "action"=>"userDel",
    "fichierController"=>'./controller/dashboard.controller.php',
    "classController"=>"DashboardController",
    "funcController"=>"delDashUser",
    "param"=>true
];
$routes["userDeco"] = [ //Deconnexion utilisateur
    "lien"=>"./index.php?controller=user&action=deconnect",
    "controller"=>"user",
    "action"=>"deconnect",
    "fichierController"=>'./controller/dashboard.controller.php',
    "classController"=>"DashboardController",
    "funcController"=>"deconnexionUser",
    "param"=>false
];
$routes["userAjout"] = [    //Ajout utilisateur
    "lien"=>"./index.php?controller=user&action=ajout",
    "controller"=>"user",
    "action"=>"ajout",
    "fichierController"=>'./controller/dashboard.controller.php',
    "classController"=>"DashboardController",
    "funcController"=>"enregistrementUser",
    "param"=>false
];


?>