<?php
class PostsModel
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
    public function RecuperationImageCarrousel($path)
    {

        $req = "
	      SELECT
		     image_Path
	      FROM
		      carrousel";
        //On prepare la requete
        $req = $this->bdd->prepare($req);
        $req->bindValue(":image_path", $path, PDO::PARAM_STR);
        //On exécute la requete
        $req->execute();
        $url = $req->fetch();

        return $url;
    }

    public function InsertionImageCarrousel($path)
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

    public function getAll()
    {

        $query = '
            SELECT
            posts.id,
            posts.title,
            posts.content,
            posts.imageFileName,
            posts.position,
            DATE_FORMAT(posts.publicationDate, \'%d/%m/%Y à %H:%i:%s\') AS publicationDate,
            writers.username AS writerUsername,
            posts.writerId
        FROM
            posts
        INNER JOIN
            writers
        ON
            posts.writerId = writers.id';
        $sth = $this->bdd->query($query);
        $res = $sth->fetchAll();
        return $res;
    }

    public function RecuperationArticleGauche()
    {

        $query = '
		SELECT
			posts.id,
			posts.title,
			posts.imageFileName,
			DATE_FORMAT(posts.publicationDate, \'%d/%m/%Y à %H:%i:%s\') AS publicationDate,
			posts.writerId,
			posts.position,
			writers.username AS writerUsername,
            posts.writerId
		FROM
			posts
		INNER JOIN
			writers
		ON
			posts.writerId = writers.id

		WHERE
		    position = \'postGauche\'
		ORDER BY
            posts.publicationDate DESC

		LIMIT 1';
        $sth = $this->bdd->query($query);
        $postsGauche = $sth->fetchAll();
        return $postsGauche;
    }

    public function RecuperationArticleDroite()
    {

        $query = '
		SELECT
			posts.id,
			posts.title,
			posts.imageFileName,
			DATE_FORMAT(posts.publicationDate, \'%d/%m/%Y à %H:%i:%s\') AS publicationDate,
			posts.writerId,
			posts.position,
			writers.username AS writerUsername,
            posts.writerId
		FROM
			posts
		INNER JOIN
			writers
		ON
			posts.writerId = writers.id
		WHERE
		    position = \'postDroite\'
		ORDER BY
		    publicationDate DESC
		LIMIT 1';
        $sth = $this->bdd->query($query);
        $postDroite = $sth->fetchAll();
        return $postDroite;
    }

    public function RecuperationArticleCentre()
    {

        $query = '
		SELECT
			posts.id,
			posts.title,
			posts.imageFileName,
			DATE_FORMAT(posts.publicationDate, \'%d/%m/%Y à %H:%i:%s\') AS publicationDate,
			posts.writerId,
			posts.position,
			writers.username AS writerUsername,
            posts.writerId
		FROM
			posts
		INNER JOIN
			writers
		ON
			posts.writerId = writers.id
		WHERE
		    position = \'postCentre\'
		ORDER BY
		    publicationDate DESC
		LIMIT 3';
        $sth = $this->bdd->query($query);
        $postsCentre = $sth->fetchAll();
        return $postsCentre;
    }

    public function getByWriter($id)
    {
        $query = '
		SELECT
			posts.id,
			posts.title,
			posts.content,
			posts.imageFileName,
			DATE_FORMAT(posts.publicationDate, \'%d/%m/%Y à %H:%i:%s\') AS publicationDate,
			writers.username AS writerUsername,
            posts.writerId
		FROM
			posts
		INNER JOIN
			writers
		ON
			posts.writerId = writers.id
		WHERE
			posts.writerId = :id
		ORDER BY
            posts.publicationDate DESC';

        $sth = $this->bdd->prepare($query);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $posts = $sth->fetchAll();
        return $posts;
    }

    public function add($title, $content, $imageFileName, $userId, $position)
    {
        $query = '
        INSERT INTO
            posts
            (title, content, imageFileName, writerId, position)
        VALUES
            (:title, :content, :imageFileName, :writerId, :position)';
        $sth = $this->bdd->prepare($query);
        $sth->bindValue(':title', ($title), PDO::PARAM_STR);
        $sth->bindValue(':content', ($content), PDO::PARAM_STR);

        if (isset($imageFileName)) {
            $sth->bindValue(':imageFileName', $imageFileName, PDO::PARAM_STR);
        } else {
            $sth->bindValue(':imageFileName', null, PDO::PARAM_NULL);
        }
        $sth->bindValue(':writerId', $userId, PDO::PARAM_INT);
        $sth->bindValue(':position', $position, PDO::PARAM_STR);
        $sth->execute();
    }

    public function getOne($id)
    {
        $query = '
		SELECT
			posts.id,
			posts.title,
			posts.content,
            posts.position,
			posts.imageFileName,
			DATE_FORMAT(posts.publicationDate, \'%d/%m/%Y à %H:%i:%s\') AS publicationDate,
			writers.username AS writerUsername,
            posts.writerId
		FROM
			posts
		INNER JOIN
			writers
		ON
			posts.writerId = writers.id
		WHERE
			posts.id = :id
			LIMIT 1';
        $sth = $this->bdd->prepare($query);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $posts = $sth->fetch();
        return $posts;
    }

    public function update($title, $content, $imageFileName, $userId, $id)
    {
        $query = '
		  UPDATE
				posts
			SET
				title = :title, content= :content, imageFileName = :imageFileName, writerId =:writerId

			WHERE id=:id

		';
        $sth = $this->bdd->prepare($query);
        $sth->bindValue(':title', trim($title), PDO::PARAM_STR);
        $sth->bindValue(':content', trim($content), PDO::PARAM_STR);
        $sth->bindValue(':id', trim($id), PDO::PARAM_INT);
        if (isset($imageFileName)) {
            $sth->bindValue(':imageFileName', $imageFileName, PDO::PARAM_STR);
        } else {
            $sth->bindValue(':imageFileName', null, PDO::PARAM_NULL);
        }
        $sth->bindValue(':writerId', $userId, PDO::PARAM_INT);
        $sth->execute();
    }
    public function getNameImage($id, $writterId)
    {
        $query =
            '
            SELECT
                imageFileName
            FROM
                posts
            WHERE
                id = :id
                AND
                writerId = :writerId
        ';
        $sth = $this->bdd->prepare($query);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->bindValue(':writerId', $writterId, PDO::PARAM_INT);
        $sth->execute();
        $imageFileName = $sth->fetchColumn();
        return $imageFileName;
    }
    public function delete($id, $writterId)
    {
        $query =
            '
            DELETE FROM
                posts
            WHERE
                id = :id
                AND
                writerId = :writerId
        ';
        $sth = $this->bdd->prepare($query);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->bindValue(':writerId', $writterId, PDO::PARAM_INT);
        $sth->execute();
    }
}
