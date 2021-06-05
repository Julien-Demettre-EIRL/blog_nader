<?php
class CarrouselModel
{
    private $bdd;
    public function __construct()
    {
        global $BDD;
        $this->bdd = new PDO
            (
            $BDD["dsn"],
            $BDD["user"],
            $BDD["mdp"],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }
    public function getAll()
    {

        $query = "
	      SELECT
		    id, 
            image_Path
	      FROM
		      carrousel";
              $sth = $this->bdd->query($query);
              $res = $sth->fetchAll();
              return $res;
    }

    public function add($path)
    {

        $url = "
		  INSERT INTO
	        carrousel
	         (image_path)
	      VALUES
	         (:img)";

        //On prepare la requete
        $query = $this->bdd->prepare($url);
        $query->bindValue(":img", $path);
        //On exécute la requete
        $url = $query->execute();
    }
    public function delete($id)
    {

        $url = "
		  DELETE FROM carrousel
          WHERE id=:id";

        //On prepare la requete
        $query = $this->bdd->prepare($url);
        $query->bindValue(":id", $id,PDO::PARAM_INT);
        //On exécute la requete
        $url = $query->execute();
    }
}