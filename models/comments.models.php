<?php
class CommentsModel
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
           *
       FROM
           comments';
        $sth = $this->bdd->query($query);
        $res = $this->bdd->fetchAll();
        return $res;
    }
    public function getAllNotValid()
    {
        $query = '
       SELECT
           *
       FROM
           comments
        WHERE valider=0';
        $sth = $this->bdd->query($query);
        $res = $sth->fetchAll();
        return $res;
    }

    public function add($postId, $author, $comment)
    {
        $req = $this->bdd->prepare('INSERT INTO comments(postId, username, content) VALUES (?, ?, ?)');
        $req->execute(array($postId, $author, $comment));
    }

    public function getByPost($id)
    {

        $req = $this->bdd->prepare('SELECT * FROM comments WHERE postId = ?');
        $req->execute(array($id));
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        return $data;

    }

    public function valid($id){
        $query = 'UPDATE comments SET valider=1 WHERE id=:id';
        $req = $this->bdd->prepare($query);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();

    }
    public function delete($id){
        $query = 'DELETE FROM comments WHERE id=:id';
        $req = $this->bdd->prepare($query);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();

    }

}
