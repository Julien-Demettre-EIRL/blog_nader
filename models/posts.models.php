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
    
    public function getAll()
    {

        $query = '
            SELECT
            posts.id,
            posts.title,
            posts.content,
            posts.imageFileName,
            posts.position,
            posts.description,
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
            posts.description,
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
            posts.description,
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
            posts.description,
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
            posts.description,
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

    public function add($title, $content, $imageFileName, $userId, $position,$desc)
    {
        $query = '
        INSERT INTO
            posts
            (title, content, imageFileName, writerId, position, description)
        VALUES
            (:title, :content, :imageFileName, :writerId, :position, :desc)';
        $sth = $this->bdd->prepare($query);
        $sth->bindValue(':title', ($title), PDO::PARAM_STR);
        $sth->bindValue(':content', ($content), PDO::PARAM_STR);
        $sth->bindValue(':desc', ($desc), PDO::PARAM_STR);

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
            posts.description,
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

    public function update($title, $content, $imageFileName, $pos, $userId, $id, $desc)
    {
        if($imageFileName!="")
        {
        $query = '
		  UPDATE
				posts
			SET
				title = :title, description= :desc, content= :content, imageFileName = :imageFileName, position = :pos, writerId =:writerId

			WHERE id=:id

		';
        } else {
            $query = '
            UPDATE
                  posts
              SET
                  title = :title,  description= :desc, content= :content, position = :pos, writerId =:writerId
  
              WHERE id=:id
  
          ';
        }
        $sth = $this->bdd->prepare($query);
        $sth->bindValue(':title', trim($title), PDO::PARAM_STR);
        $sth->bindValue(':content', trim($content), PDO::PARAM_STR);
        $sth->bindValue(':desc', trim($desc), PDO::PARAM_STR);
        $sth->bindValue(':id', trim($id), PDO::PARAM_INT);
        $sth->bindValue(':pos', trim($pos), PDO::PARAM_STR);
        if ($imageFileName!="") {
            $sth->bindValue(':imageFileName', $imageFileName, PDO::PARAM_STR);
        } 
        $sth->bindValue(':writerId', $userId, PDO::PARAM_INT);
        $sth->execute();
    }
    public function getNameImage($id)
    {
        $query =
            '
            SELECT
                imageFileName
            FROM
                posts
            WHERE
                id = :id
        ';
        $sth = $this->bdd->prepare($query);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $imageFileName = $sth->fetchColumn();
        return $imageFileName;
    }
    public function delete($id)
    {
        $query =
            '
            DELETE FROM
                posts
            WHERE
                id = :id
        ';
        $sth = $this->bdd->prepare($query);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
    }
}
