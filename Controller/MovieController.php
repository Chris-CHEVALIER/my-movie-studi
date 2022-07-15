<?php

class MovieController
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
        $movies = [];
        $req = $this->pdo->query("SELECT * FROM `movie`");
        $data = $req->fetchAll();
        foreach ($data as $movie) {
            $movies[] = new Movie($movie);
        }
        return $movies;
    }

    public function get(int $id) //: Movie
    {
        # code...
    }

    public function create(Movie $newMovie): void
    {
        $req = $this->pdo->prepare("INSERT INTO `movie` (title, description, image_url, release_date, director, category_id) VALUES (:title, :description, :image_url, :release_date, :director, :category_id)");
        $req->bindValue(":title", $newMovie->getTitle(), PDO::PARAM_STR);
        $req->bindValue(":description", $newMovie->getDescription(), PDO::PARAM_STR);
        $req->bindValue(":image_url", $newMovie->getImage_url(), PDO::PARAM_STR);
        $req->bindValue(":release_date", $newMovie->getRelease_date(), PDO::PARAM_STR);
        $req->bindValue(":director", $newMovie->getDirector(), PDO::PARAM_STR);
        $req->bindValue(":category_id", $newMovie->getCategory_id(), PDO::PARAM_INT);
        $req->execute();
    }

    public function update(Movie $movie): void
    {
        # code...
    }

    public function delete(int $id): void
    {
        $req = $this->pdo->prepare("DELETE FROM `movie` WHERE id = :id");
        $req->bindParam(":id", $id, PDO::PARAM_INT);
        $req->execute();
    }
}
