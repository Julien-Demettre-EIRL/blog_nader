<?php
class WritersModel
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
        $query = 'SELECT * FROM writers';
        $sth = $this->bdd->query($query);
        $writers = $sth->fetchAll();
        return $writers;
    }

    public function getOne($id)
    {
        $query = '
        SELECT
       *
    FROM
        writers
    WHERE
        id = :id';
        $sth = $this->bdd->prepare($query);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $writer = $sth->fetch();
        return $writer;
    }

    public function add($username, $password)
    {
        $query = '
			INSERT INTO
				writers
				(username, hashedPassword)
			VALUES
				(:username, :hashedPassword)';
        $sth = $this->bdd->prepare($query);
        $sth->bindValue(':username', trim($username), PDO::PARAM_STR);
        $sth->bindValue(':hashedPassword', password_hash(trim($password), PASSWORD_BCRYPT), PDO::PARAM_STR);
        $sth->execute();
    }

    public function getByName($username)
    {
        $query = '
        SELECT
            id,
            username,
            hashedPassword,
            nbConnect
        FROM
            writers
        WHERE
            username = :username';
        $sth = $this->bdd->prepare($query);
        $sth->bindValue(':username', trim($username), PDO::PARAM_STR);
        $sth->execute();
        $writer = $sth->fetch();

        return $writer;
    }
    public function debloqueUser($id)
    {
        $query = '
            UPDATE writers SET
                nbConnect = :con
            WHERE
                id = :id';
            $sth = $this->bdd->prepare($query);
            $sth->bindValue(':id', $id, PDO::PARAM_INT);
            $sth->bindValue(':con', 0, PDO::PARAM_INT);
            $sth->execute();
    }
    public function connect($email,$pass){
        $writer = $this->getByName($email);
        if ($writer !== false and password_verify(trim($pass), $writer['hashedPassword']) and ($writer['nbConnect']<3)) {
            $query = '
            UPDATE writers SET
                nbConnect = :con
            WHERE
                username = :username';
            $sth = $this->bdd->prepare($query);
            $sth->bindValue(':username', trim($email), PDO::PARAM_STR);
            $sth->bindValue(':con', 0, PDO::PARAM_INT);
            $sth->execute();
            return 1;
        } else {
            if($writer['nbConnect']>=3)
            {
                return -2;
            }
            if($writer!== false)
            {
                $query = '
                UPDATE writers SET
                    nbConnect = :con
                WHERE
                    username = :username';
                $sth = $this->bdd->prepare($query);
                $sth->bindValue(':username', trim($email), PDO::PARAM_STR);
                $sth->bindValue(':con', ($writer['nbConnect']+1), PDO::PARAM_INT);
                $sth->execute();
                return -1;
            }
            return -3;
        }
    }
    public function delete($id)
    {

        $url = "
		  DELETE FROM writers
          WHERE id=:id";

        //On prepare la requete
        $query = $this->bdd->prepare($url);
        $query->bindValue(":id", $id,PDO::PARAM_INT);
        //On exécute la requete
        $url = $query->execute();
    }
}
