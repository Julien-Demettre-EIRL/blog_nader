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
		    *
	      FROM
		      video";
              $sth = $this->bdd->query($query);
              $res = $sth->fetchAll();
              return $res;
    }
    public function getOne($id)
    {
        $query = '
		SELECT
            *
        FROM
            video
		WHERE
			video.id = :id
		LIMIT 1';
        $sth = $this->bdd->prepare($query);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $video = $sth->fetch();
        return $video;
    }
    public function getThree()
    {

        $query = "
	      SELECT
		    *
	      FROM
		      video
              ORDER BY id DESC
              LIMIT 3";
              $sth = $this->bdd->query($query);
              $res = $sth->fetchAll();
              return $res;
    }

    public function add($path,$path2,$titre,$desc)
    {

        $url = "
		  INSERT INTO
	        video
	         (video_path, imgvideo_path, titre, description)
	      VALUES
	         (:vid, :img, :titre, :desc)";

        //On prepare la requete
        $query = $this->bdd->prepare($url);
        $query->bindValue(":vid", $path);
        $query->bindValue(":img", $path2);
        $query->bindValue(":titre", $titre);
        $query->bindValue(":desc", $desc);
        //On exécute la requete
        $url = $query->execute();
    }
    public function delete($id)
    {

        $url = "
		  DELETE FROM video
          WHERE id=:id";

        //On prepare la requete
        $query = $this->bdd->prepare($url);
        $query->bindValue(":id", $id,PDO::PARAM_INT);
        //On exécute la requete
        $url = $query->execute();
    }
    public function getNameVid($id)
    {
        $query =
            '
            SELECT
            video_path
            FROM
                video
            WHERE
                id = :id
         ';
        $sth = $this->bdd->prepare($query);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $videoFileName = $sth->fetchColumn();
        return $videoFileName;
    }
}