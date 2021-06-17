<?php
 require dirname(__FILE__) . '/../vendor/autoload.php';
 use \Firebase\JWT\JWT;

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
        

        require_once dirname(__FILE__) . '/../models/video.models.php';
        $videoModel = new VideoModel();

        $vids = $videoModel->getThree();
     //   var_dump($vids);
        $tabJwt = [];
        foreach($vids as $key=>$vid)
        {
            $key = "Nader_The_Best";
            $date = new DateTime();
            $date->modify('+1 hour');
            $payload = array(
                "expire" => $date->getTimestamp(),
                "id"=>$vid['id']
            );
    
            $jwt = JWT::encode($payload, $key);
            array_push($tabJwt,urlencode($jwt));
            //$tabJwt[$key]=urlencode($jwt);
        }
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
    private function getRequestHeaders() {
        $headers = array();
        foreach($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }
        return $headers;
    }
    public function lireVideo(){
      
        global $BDD;
        global $_SERVER;
      
      $headers = $this->getRequestHeaders();
      
      
      $bok = false;
      foreach ($headers as $header => $value) {
          if($header=='Range') $bok=true;
      }
       $bok = true;
      $bok2 = false;
      $date = new DateTime();
      $key = "Nader_The_Best";
      $jwt = urldecode($_GET['id']);
      $decoded = JWT::decode($jwt, $key, array('HS256'));
      $mtn = intval($date->getTimestamp());
      $decoded = (array) $decoded;
      $tok = intval($decoded["expire"]);
      $id = intval($decoded["id"]);
      //var_dump($bok);
      
      
        if($mtn<$tok)
      {
        $bok2=true;
      }
      
      if((int)$id!=0 && $bok && $bok2)
      {
        require_once dirname(__FILE__) . '/../models/video.models.php';
        //var_dump('test');
        $videoModel = new VideoModel();

        $videoFileName = $videoModel->getNameVid((int) $id);
        $path = dirname(__FILE__) . "/../video/".$videoFileName;
        $size=filesize($path);
      
        $fm=@fopen($path,'rb');
        if(!$fm) {
          // You can also redirect here
          header ("HTTP/1.0 404 Not Found");
          die();
        }
      
        $begin=0;
        $end=$size;
        // $range = '';

        list($size_unit, $range_orig) = explode('=', $_SERVER['HTTP_RANGE'], 2);
        if ($size_unit == 'bytes')
        {
            //multiple ranges could be specified at the same time, but for simplicity only serve the first range
            //http://tools.ietf.org/id/draft-ietf-http-range-retrieval-00.txt
            list($range, $extra_ranges) = explode(',', $range_orig, 2);
        }
        else
        {
            $range = '';
        }
    
        list($seek_start, $seek_end) = explode('-', $range, 2);
      
        //set start and end based on range (if set), else set defaults
        //also check for invalid ranges.
        $end = (empty($seek_end)) ? ($size - 1) : min(abs(intval($seek_end)),($size - 1));
        $begin = (empty($seek_start) || $seek_end < abs(intval($seek_start))) ? 0 : max(abs(intval($seek_start)),0);
        if($begin>0||$end<$size)
          header('HTTP/1.0 206 Partial Content');
        else
          header('HTTP/1.0 200 OK');
      
        header("Content-Type: video/mp4");
        header('Accept-Ranges: bytes');
        header('Content-Length:'.($end-$begin));
        header("Content-Range: bytes ".$begin."-".($end+1)."/".$size);
      
        $cur=$begin;
        fseek($fm,$begin,0);
      
        print fread($fm,$end-$begin);
        die();
      }
      else {
        if($bok2) {
          http_response_code(401);
          echo "Vous n'êts pas autoriser à voir cette video";
        }
        else {
          http_response_code(401);
          echo "Cette vidéo est périmée";
        }
      }
    }
}
