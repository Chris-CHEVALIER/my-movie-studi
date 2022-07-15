<?php

//require_once "../config/DotEnv.php";

class CategoryController
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
        $req = $this->pdo->query("SELECT * FROM `category`");
        $data = $req->fetchAll();
        foreach ($data as $category) {
            $categories[] = new Category($category);
        }
        return $categories;
    }

    public function get(int $id): Category
    {
        $req = $this->pdo->prepare("SELECT * FROM `category` WHERE id = :id");
        $req->bindParam(":id", $id, PDO::PARAM_INT);
        $req->execute();
        $data = $req->fetch();
        $category = new Category($data);
        return $category;
    }

    public function create(Category $newCategory): void
    {
        $req = $this->pdo->prepare("INSERT INTO `category` (name, color) VALUES (:name, :color)");
        $req->bindParam(":name", $newCategory->getName(), PDO::PARAM_STR);
        $req->bindParam(":color", $newCategory->getColor(), PDO::PARAM_STR);
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
