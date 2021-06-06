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
            hashedPassword
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
}
