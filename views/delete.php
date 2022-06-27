<?php

function loadClass(string $class)
{
    if ($class === "DotEnv") {
        require_once "../config/$class.php";
    } else if (str_contains($class, "Controller")) {
        require_once "../Controller/$class.php";
    } else {
        require_once "../Entity/$class.php";
    }
}

spl_autoload_register("loadClass");

$movieController = new MovieController();
$movieController->delete($_GET["id"]);
echo "<script>window.location='../index.php'</script>";
