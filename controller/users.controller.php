<?php
class UsersController
{
    public function connexion()
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
    public function deconnexion()
    {
        global $routes;
        session_unset();
        session_destroy();
        //    Redirection vers la page d'identification
        header('location: '.$routes["postGetArticle"]["lien"]);
        exit;
    }
    public function enregistrement()
    {
        global $routes;
        if (!empty($_POST)) {

            require_once dirname(__FILE__) . '/../models/writers.models.php';
            $writerModel = new WritersModel();
            $writerModel->add($_POST['username'], $_POST['password']);

            //    Redirection vers la page d'identification
            header('Location: '.$routes["userCon"]["lien"]);
            exit;
        }

        //    Inclusion du HTML
        require dirname(__FILE__) . '/../views/sign-up.phtml';
    }
}
