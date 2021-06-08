<?php
class VideoModel
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
            video_path
	      FROM
		      video";
              $sth = $this->bdd->query($query);
              $res = $sth->fetchAll();
              return $res;
    }

    public function add($path)
    {

        $url = "
		  INSERT INTO
	        video
	         (video_path)
	      VALUES
	         (:vid)";

        //On prepare la requete
        $query = $this->bdd->prepare($url);
        $query->bindValue(":vid", $path);
        //On exécute la requete
        $url = $query->execute();
    }
    public function delete($id)
    {
/*
        $url = "
		  DELETE FROM carrousel
          WHERE id=:id";

        //On prepare la requete
        $query = $this->bdd->prepare($url);
        $query->bindValue(":id", $id,PDO::PARAM_INT);
        //On exécute la requete
        $url = $query->execute();*/
    }
    public function getNameImage($id)
    {
    /*    $query =
            '
            SELECT
            image_path
            FROM
                carrousel
            WHERE
                id = :id
         ';
        $sth = $this->bdd->prepare($query);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $imageFileName = $sth->fetchColumn();
        return $imageFileName;*/
    }
}