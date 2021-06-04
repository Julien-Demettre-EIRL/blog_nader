<?php
class DashboardController
{
    public function afficheDashboard()
    {
        global $routes;
        //    Si l'utilisateur n'est pas identifié
        if (!array_key_exists('userId', $_SESSION)) {
            //    Redirection vers la page d'identification
            header('Location: '.$routes["userCon"]["lien"]);
            exit;
        }

        require_once dirname(__FILE__) . '/../models/posts.models.php';
        $postModel = new PostsModel();

        $posts = $postModel->getAll();
       /*
        $msg = '';
        if (isset($_POST['upload'])) {
            $image = 'img/logo_Service_Presse/' . uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $path = 'img/' . $image;

            var_dump($_POST, $_FILES);
            require '../models/posts.models.php';
            if ($req) {
                //utiliser la fonction
                move_uploaded_file($_FILES['image']['tmp_name'], $path);
                $msg = 'l"image a été chargée avec succés!';
            } else {
                $msg = 'Echec du chargement de l"image!';
            }
        }*/

        require dirname(__FILE__) . '/../views/dashboard.phtml';
    }
    public function afficheDashCarrousel()
    {
        global $routes;
        //    Si l'utilisateur n'est pas identifié
        if (!array_key_exists('userId', $_SESSION)) {
            //    Redirection vers la page d'identification
            header('Location: '.$routes["userCon"]["lien"]);
            exit;
        }

        require dirname(__FILE__) . '/../views/dashCarrousel.phtml';
    }
    public function afficheDashComment()
    {
        global $routes;
        //    Si l'utilisateur n'est pas identifié
        if (!array_key_exists('userId', $_SESSION)) {
            //    Redirection vers la page d'identification
            header('Location: '.$routes["userCon"]["lien"]);
            exit;
        }

        require dirname(__FILE__) . '/../views/dashComments.phtml';
    }
    public function afficheDashUser()
    {
        global $routes;
        //    Si l'utilisateur n'est pas identifié
        if (!array_key_exists('userId', $_SESSION)) {
            //    Redirection vers la page d'identification
            header('Location: '.$routes["userCon"]["lien"]);
            exit;
        }

        require dirname(__FILE__) . '/../views/dashUser.phtml';
    }

}
