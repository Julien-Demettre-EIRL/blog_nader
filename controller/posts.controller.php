<?php
class PostsController
{

    public function getAjoutArticle($id)
    {
        global $routes;
        
            require_once dirname(__FILE__) . '/../models/posts.models.php';
        
            $postModel = new PostsModel();
        
            $post = $postModel->getOne($id);
        
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

        require_once dirname(__FILE__) . '/../models/carrousel.models.php';
        $carrouselModel = new CarrouselModel();
        $imgs = $carrouselModel->getAll();
        //    Inclusion du HTML
        require dirname(__FILE__) . '/../views/index.phtml';
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
    public function connexionUser()
    {
        global $routes;
        if (!empty($_POST)) {
            require_once dirname(__FILE__) . '/../models/writers.models.php';
            $writerModel = new WritersModel();
            $writer = $writerModel->getByName($_POST['email']);
            if ($writer !== false and password_verify(trim($_POST['password']), $writer['hashedPassword'])) {
                $_SESSION['userId'] = intval($writer['id']);
                header('Location: '.$routes["dashboard"]["lien"]);
                exit;
            } else {
                header('Location: '.$routes["userCon"]["lien"]);
                exit;
            }
        }
        require dirname(__FILE__) . '/../views/sign-in.phtml';
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
