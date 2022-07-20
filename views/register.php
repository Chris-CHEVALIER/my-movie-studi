<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/main.css">
    <title>My Movies</title>
</head>

<body>
    <?php
    session_start();
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

    $userController = new UserController();

    if ($_POST) {
        if ($_POST["password"] === $_POST["confirmPassword"]) {
            unset($_POST["confirmPassword"]);
            $_POST["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
            //echo $_POST["password"];
            $newUser = new User($_POST);
            $userController->create($newUser);
            $_SESSION["username"] = $_POST["username"];
            $_SESSION["email"] = $_POST["email"];
            echo "<script>window.location='../index.php'</script>";
        } else {
            echo "<p>Le mot passe ne correspond pas.</p>";
        }
    }

    /* $movie = new Movie([
        "id" => 1,
        "title" => "Avatar",
        "description" => "Un film avec des gens bleus... :)",
        "image_url" => "https://m.media-amazon.com/images/I/615Yl386WYL._AC_SY606_.jpg",
        "release_date" => "2009-12-16",
        "director" => "James Cameron",
        "category_id" => 3
    ]);

    $firstName = "Michael";
    $firstNames = array("Christelle", "Christophe", $firstName, "Aline");
    $myInformations = [
        "firstName" => "Chris",
        "lastName" => "Chevalier",
        "age" => 29
    ];

    function displayNames(array $names): string
    {
        $string = "Dans ma classe, il y a ";
        $i = 0;
        while ($i <= sizeof($names) - 1) {
            if ($i === 2) {
                $i++;
                continue;
            }
            $string .= $names[$i];
            $i !== 0 && $string .= ", ";
            $i++;
        }
        return $string . "<br/>";
    }

    $firstNames2 = array("Lionel", "Philippe", "Laurent", "Melissa");

    $result = displayNames($firstNames);
    echo displayNames($firstNames2);

    echo $result;

    echo "J'ai un tableau de " . count($firstNames) . " éléments";
    for ($i = count($firstNames) - 1; $i >= 0; $i--) {
        echo "Je m'appelle $firstNames[$i] ! :)";
    }
    foreach ($myInformations as $key => $information) {
        echo "$information ! :)<br/>";
    } */
    ?>
    <header>
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="../index.php"><i class="bi bi-film"></i>My Movies</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <div class="d-flex">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Accueil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./views/create.php">Publier un film</a>
                            </li>
                        </div>
                        <div class="d-flex">
                            <li class="nav-item">
                                <a class="nav-link" href="./views/register.php">S'inscrire</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./views/login.php">Se connecter</a>
                            </li>
                        </div>
                    </ul>

                </div>
            </div>
        </nav>
    </header>

    <main class="container d-flex flex-column justify-content-center text-center">
        <h1>My Movies</h1>
        <h3>Découvrez et partagez des films !</h3>
        <img class="logo mx-auto" src="../images/logo.png" width="250px" alt="Logo My Movies">

        <h4>Créer un compte utilisateur</h4>
        <section class="container d-flex justify-content-center">
            <form method="post">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Nom d'utilisateur" required>
                <label for="email">E-mail</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Votre adresse e-mail" required>
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Votre mot de passe" required>
                <label for="confirmPassword">Confirmer le mot de passe</label>
                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirmez votre mot de passe" required>

                <input type="submit" class="btn btn-primary my-3" value="Créer un compte">
            </form>
        </section>
    </main>
</body>

</html>