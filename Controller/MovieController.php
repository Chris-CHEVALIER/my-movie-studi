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

    public function get(int $id): Movie
    {
        $req = $this->pdo->prepare("SELECT * FROM `movie` WHERE id = :id");
        $req->bindParam(":id", $id, PDO::PARAM_INT);
        $req->execute();
        $data = $req->fetch();
        $movie = new Movie($data);
        return $movie;
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
        $req = $this->pdo->prepare("UPDATE `movie` SET title = :title, description = :description, image_url = :image_url, release_date = :release_date, director = :director, category_id = :category_id WHERE id = :id");

        $req->bindValue(":title", $movie->getTitle(), PDO::PARAM_STR);
        $req->bindValue(":description", $movie->getDescription(), PDO::PARAM_STR);
        $req->bindValue(":image_url", $movie->getImage_url(), PDO::PARAM_STR);
        $req->bindValue(":release_date", $movie->getRelease_date(), PDO::PARAM_STR);
        $req->bindValue(":director", $movie->getDirector(), PDO::PARAM_STR);
        $req->bindValue(":category_id", $movie->getCategory_id(), PDO::PARAM_INT);
        $req->bindValue(":id", $movie->getId(), PDO::PARAM_INT);

        $req->execute();
    }

    public function delete(int $id): void
    {
        $req = $this->pdo->prepare("DELETE FROM `movie` WHERE id = :id");
        $req->bindParam(":id", $id, PDO::PARAM_INT);
        $req->execute();
    }
}
