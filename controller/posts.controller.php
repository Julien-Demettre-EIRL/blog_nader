<?php
class PostsController
{

    public function getAjoutArticle($id)
    {
        global $routes;
        
            require_once dirname(__FILE__) . '/../models/posts.models.php';
            require_once dirname(__FILE__) . '/../models/comments.models.php';

            $postModel = new PostsModel();
            $commentModel = new CommentsModel();

            $post = $postModel->getOne($id);
            $comments = $commentModel->getByPost($id);

            if (!empty($_POST)) {
                extract($_POST);
                $errors = array();
                $author = strip_tags($author);
                $comment = strip_tags($content);
                if (empty($author)) {
                    array_push($errors, 'Entrez votre email');
                }

                if (empty($comment)) {
                    array_push($errors, 'Entrez un commentaire');
                }

                if (count($errors) == 0) {
                    $comment = $commentModel->add($postId, $author, $content);
                    $success = "Votre commentaire est soumis au modérateur avant d'être publié";
                }
            }

            require dirname(__FILE__) . '/../views/post.phtml';
        

    }
    public function getArticles()
    {
        global $routes;
        global $BDD;

        if (!isset($BDD["dsn"])) {
            echo 'test';
            $this->modeInstall();
        } else {
        require_once dirname(__FILE__) . '/../models/posts.models.php';
        $postModel = new PostsModel();
        /*    $posts = $postModel->getAll();
        require dirname(__FILE__) . '/../views/posts.phtml'; */

        $postsGauche = $postModel->RecuperationArticleGauche();
        $postsCentre = $postModel->RecuperationArticleCentre();
        $postsDroite = $postModel->RecuperationArticleDroite();
        //    Inclusion du HTML
        require dirname(__FILE__) . '/../views/index.phtml';
        }
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

        //    Traitement du formulaire de publication d'un article s'il a été soumis
        if (!empty($_POST)) {

            $imageFileName = $this->moveImg('image');

            $postModel->update($_POST['title'], $_POST['content'], $imageFileName, (int) $_SESSION['userId'], (int) $_POST['id']);

            //    Redirection vers le tableau de bord
            header('Location: ' . $routes["dashboard"]["lien"]);
            exit;
        }

        //    Inclusion du HTML
        require dirname(__FILE__) . '/../views/edit-post.phtml';

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
                echo'ajout Ok !';
          //  header('Location: ' . $routes["dashboard"]["lien"]);
            exit;
            }
            
        }
        else {
        //    Inclusion du HTML
        require dirname(__FILE__) . '/../views/dashboard.phtml';
        }

    }
    public function listeArticleRedacteur($idRedac)
    {
        global $routes;
        require_once dirname(__FILE__) . '/../models/posts.models.php';
        require_once dirname(__FILE__) . '/../models/writers.models.php';

        $postModel = new PostsModel();
        $writerModel = new WritersModel();

        $writer = $writerModel->getOne($idRedac);
        $posts = $postModel->getByWriter($idRedac);

        //    Inclusion du HTML
        require dirname(__FILE__) . '/../views/writer.phtml';
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
                echo 'Le fichier n\'a pas pu être récupéré…';
                return false;
            }
        }
        return $imageFileName;
    }
    private function modeInstall()
    {
        global $routes;
        //    Inclusion du HTML
        require dirname(__FILE__) . '/../views/install.phtml';
    }
    public function endSetup()
    {
        global $routes;
        global $BDD;
        
        if (!isset($BDD["dsn"]) && !empty($_POST["serveur"]) && !empty($_POST["nomBdd"]) && !empty($_POST["port"]) && !empty($_POST["utilisateur"]) && !empty($_POST["mdp"])) {
            try {
                $this->bdd = new PDO
                    (
                    'mysql:host=' . $_POST["serveur"] . ';dbname=' . $_POST["nomBdd"] . ';port=' . $_POST["port"] . ';charset=utf8',
                    $_POST["utilisateur"],
                    $_POST["mdp"],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]
                );
                $numFich = fopen(dirname(__FILE__) . '/../includes/bdd.php', 'w');
                fwrite($numFich, "<?php\r\n");
                fwrite($numFich, "\$BDD = [\r\n");
                fwrite($numFich, "\"dsn\" => \"" . "mysql:host=" . $_POST["serveur"] . ";dbname=" . $_POST["nomBdd"] . ";port=" . $_POST["port"] . ";charset=utf8" . "\",\r\n");
                fwrite($numFich, "\"user\" => \"" . $_POST["utilisateur"] . "\",\r\n");
                fwrite($numFich, "\"mdp\" => \"" . $_POST["mdp"] . "\"\r\n");
                fwrite($numFich, '];');

               // echo "Tout vas bien";
                header('Location: ' . $routes["postGetArticle"]["lien"]);

            } catch (PDOException $e) {
                echo "Erreur utilisateur BDD";
                var_dump($BDD);
            var_dump($_POST);
            }

        }
        else {
            echo 'param manquant';
            var_dump($BDD);
            var_dump($_POST);
        }
    }
}
