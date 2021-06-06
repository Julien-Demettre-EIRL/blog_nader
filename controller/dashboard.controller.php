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
        $postEC["id"]="";
        $postEC["title"]="";
        $postEC["content"]="";
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
    public function delArticle($id)
    {
        global $routes;
        //    Si l'utilisateur n'est pas identifié
        if (!array_key_exists('userId', $_SESSION)) {
            //    Redirection vers la page d'identification
            header('Location: ' . $routes["userCon"]["lien"]);
            exit;
        }

        require_once dirname(__FILE__) . '/../models/posts.models.php';
        $postModel = new PostsModel();

        //    Récupération du nom de l'image de l'article
        $imageFileName = $postModel->getNameImage((int) $id, (int) $_SESSION['userId']);

        //    Suppression de l'éventuelle image
        if (!is_null($imageFileName)) {
            unlink('uploads/' . $imageFileName);
        }

        //    Suppression de l'article
        $postModel->delete((int) $id, (int) $_SESSION['userId']);

        //    Redirection vers le tableau de bord
        header('Location: ' . $routes["dashboard"]["lien"]);
        exit;
    }
    public function editArticle($id)
    {
        global $routes;
        require_once dirname(__FILE__) . '/../models/posts.models.php';
        $postModel = new PostsModel();

        //    Si l'utilisateur n'est pas identifié
        if (!array_key_exists('userId', $_SESSION)) {
            //    Redirection vers la page d'identification
            header('Location: ' . $routes["userCon"]["lien"]);
            exit;
        }

        $posts = $postModel->getAll();
        $postEC = $postModel->getOne($id);
        //    Traitement du formulaire de publication d'un article s'il a été soumis
        if (!empty($_POST)) {

            $imageFileName = $this->moveImg('image');
            if($imageFileName!==false)
            {
                $postModel->update($_POST['title'], $_POST['content'], $imageFileName, $_POST['position'], (int) $_SESSION['userId'], (int) $_POST['id']);
            //    Redirection vers le tableau de bord
            header('Location: ' . $routes["dashboard"]["lien"]);
            exit;
            }
            
        }
        else {
            //    Inclusion du HTML
            require dirname(__FILE__) . '/../views/dashboard.phtml';
        }

    }
     
    public function ajoutArticle()
    {
        global $routes;
        //    Si l'utilisateur n'est pas identifié
        if (!array_key_exists('userId', $_SESSION)) {
            //    Redirection vers la page d'identification
            header('Location: ' . $routes["userCon"]["lien"]);
            exit;
        }

        //    Traitement du formulaire de publication d'un article s'il a été soumis
        if (!empty($_POST)) {
            require_once dirname(__FILE__) . '/../models/posts.models.php';
            $postModel = new PostsModel();
            echo "on post";
            $imageFileName = $this->moveImg('image');
            if($imageFileName!==false)
            {

            $postModel->add($_POST['title'], $_POST['content'], $imageFileName, $_SESSION['userId'], $_POST['position']);

            //    Redirection vers le tableau de bord
         //       echo'ajout Ok !';
                  header('Location: ' . $routes["dashboard"]["lien"]);
            exit;
            }
            
        }
        else {
        //    Inclusion du HTML
        require dirname(__FILE__) . '/../views/dashboard.phtml';
        }

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
        require_once dirname(__FILE__) . '/../models/carrousel.models.php';
        $carrouselModel = new CarrouselModel();

        $imgs = $carrouselModel->getAll();

        require dirname(__FILE__) . '/../views/dashCarrousel.phtml';
    }
    public function ajoutImgCar()
    {
        global $routes;
        //    Si l'utilisateur n'est pas identifié
        if (!array_key_exists('userId', $_SESSION)) {
            //    Redirection vers la page d'identification
            header('Location: ' . $routes["userCon"]["lien"]);
            exit;
        }

        //    Traitement du formulaire de publication d'un article s'il a été soumis
        if (!empty($_POST)) {
            require_once dirname(__FILE__) . '/../models/carrousel.models.php';
            $carrouselModel = new CarrouselModel();
            
            $imageFileName = $this->moveImg('image');
            if($imageFileName!==false)
            {

                $carrouselModel->add($imageFileName);

            //    Redirection vers le tableau de bord
         //       echo'ajout Ok !';
                  header('Location: ' . $routes["dashboardCarrousel"]["lien"]);
            exit;
            }
            
        }
        else {
        //    Inclusion du HTML
        require dirname(__FILE__) . '/../views/dashboard.phtml';
        }

    }
    public function delImgCar($id)
    {
        global $routes;
        //    Si l'utilisateur n'est pas identifié
        if (!array_key_exists('userId', $_SESSION)) {
            //    Redirection vers la page d'identification
            header('Location: ' . $routes["userCon"]["lien"]);
            exit;
        }

        require_once dirname(__FILE__) . '/../models/carrousel.models.php';
        $carrouselModel = new CarrouselModel();

        //    Récupération du nom de l'image de l'article
        $imageFileName = $carrouselModel->getNameImage((int) $id);

        //    Suppression de l'éventuelle image
        if (!is_null($imageFileName)) {
            unlink('uploads/' . $imageFileName);
        }

        //    Suppression de l'article
        $carrouselModel->delete((int) $id);

        //    Redirection vers le tableau de bord
        header('Location: ' . $routes["dashboardCarrousel"]["lien"]);
        exit;
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

        require_once dirname(__FILE__) . '/../models/comments.models.php';
        $commentModel = new CommentsModel();
        $comments = $commentModel->getAllNotValid();
        require dirname(__FILE__) . '/../views/dashComments.phtml';
    }
    public function validComment($id){
        global $routes;
          //    Si l'utilisateur n'est pas identifié
          if (!array_key_exists('userId', $_SESSION)) {
            //    Redirection vers la page d'identification
            header('Location: '.$routes["userCon"]["lien"]);
            exit;
        }

        require_once dirname(__FILE__) . '/../models/comments.models.php';
        $commentModel = new CommentsModel();
        $commentModel->valid((int)$id);
        header('Location: ' . $routes["dashboardComment"]["lien"]);
        exit;

    }
    public function deleteComment($id){
        global $routes;
          //    Si l'utilisateur n'est pas identifié
          if (!array_key_exists('userId', $_SESSION)) {
            //    Redirection vers la page d'identification
            header('Location: '.$routes["userCon"]["lien"]);
            exit;
        }

        require_once dirname(__FILE__) . '/../models/comments.models.php';
        $commentModel = new CommentsModel();
        $commentModel->delete((int)$id);

        header('Location: ' . $routes["dashboardComment"]["lien"]);
        exit;

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
        require_once dirname(__FILE__) . '/../models/writers.models.php';
        $writerModel = new WritersModel();
        $usrs = $writerModel->getAll();

        require dirname(__FILE__) . '/../views/dashUser.phtml';
    }
    public function enregistrementUser()
    {
        global $routes;
         //    Si l'utilisateur n'est pas identifié
         if (!array_key_exists('userId', $_SESSION)) {
            //    Redirection vers la page d'identification
            header('Location: '.$routes["userCon"]["lien"]);
            exit;
        }

        if (!empty($_POST)) {

            require_once dirname(__FILE__) . '/../models/writers.models.php';
            $writerModel = new WritersModel();
            $writerModel->add($_POST['username'], $_POST['password']);

            //    Redirection vers la page d'identification
            header('Location: '.$routes["dashboardUser"]["lien"]);
            exit;
        }

        //    Inclusion du HTML
        require dirname(__FILE__) . '/../views/sign-up.phtml';
    }
    public function deconnexionUser()
    {
        global $routes;
        session_unset();
        session_destroy();
        //    Redirection vers la page d'identification
        header('location: '.$routes["postGetArticle"]["lien"]);
        exit;
    }
    private function moveImg($nomChamp)
    {
        $imageFileName = "";
        if (array_key_exists($nomChamp, $_FILES)) {
            if ($_FILES[$nomChamp]['error'] == 0) {
                if (in_array(mime_content_type($_FILES[$nomChamp]['tmp_name']), ['image/png', 'image/jpeg'])) {
                    if ($_FILES[$nomChamp]['size'] <= 3000000) {
                        $imageFileName = uniqid() . '.' . pathinfo($_FILES[$nomChamp]['name'], PATHINFO_EXTENSION);
                        if (!file_exists(dirname(__FILE__) . '/../uploads/')) {
                            mkdir(dirname(__FILE__) . '/../uploads/', 0777, true);
                        }
                        if(!move_uploaded_file($_FILES[$nomChamp]['tmp_name'], dirname(__FILE__) . '/../uploads/' . $imageFileName))
                        {
                            echo 'Le fichier n\'a pas été déplacé';
                            return false;
                        }
                    } else {
                        echo 'Le fichier est trop volumineux…';
                        return false;
                    }
                } else {
                    echo 'Le type mime du fichier est incorrect…';
                    return false;
                }
            } else {
              //  echo 'Le fichier n\'a pas pu être récupéré…';
                return "";
            }
        }
        return $imageFileName;
    }
}
