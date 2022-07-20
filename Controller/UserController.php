<?php

class UserController
{
    private PDO $pdo;

    public function __construct()
    {
        try {
            (new DotEnv(__DIR__ . '/../.env'))->load();
            $this->setPdo(new PDO(getenv('DATABASE_DNS'), getenv('DATABASE_USER'), getenv('DATABASE_PASSWORD')));
        } catch (PDOException $error) {
            var_dump($error);
            echo "<p style='color: red'>$error</p>";
        }
    }

    public function setPdo(PDO $pdo)
    {
        $this->pdo = $pdo;
        return $this;
    }

    public function getAll(): array
    {
        $categories = [];
        $req = $this->pdo->query("SELECT * FROM `user`");
        $data = $req->fetchAll();
        foreach ($data as $user) {
            $users[] = new User($user);
        }
        return $users;
    }

    public function get(int $id): User
    {
        $req = $this->pdo->prepare("SELECT * FROM `user` WHERE id = :id");
        $req->bindParam(":id", $id, PDO::PARAM_INT);
        $req->execute();
        $data = $req->fetch();
        $user = new User($data);
        return $user;
    }

    public function create(User $newUser): void
    {
        $req = $this->pdo->prepare("INSERT INTO `user` (username, email, password) VALUES (:username, :email, :password)");
        $req->bindValue(":username", $newUser->getUsername(), PDO::PARAM_STR);
        $req->bindValue(":email", $newUser->getEmail(), PDO::PARAM_STR);
        $req->bindValue(":password", $newUser->getPassword(), PDO::PARAM_STR);
        $req->execute();
    }

    public function update(Category $category): void
    {
        # code...
    }

    public function delete(Category $category): void
    {
        # code...
    }
}
