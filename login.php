<?php
session_start();

if (isset($_SESSION["user"])) {
    // header("location: index.php");
}

$error = "";


$_username = "admin@ece.com"; // identifiant admin
$_password = sha1("1234");

if (isset($_POST["login"])) {
    extract($_POST);
    if (!empty($username) && !empty($password)) {
        $password = sha1($password);

        if ($username == $_username && $password == $_password) {
            $_SESSION["user"] = $username;
            
            header("location: index.php"); // a changer en fonction de la page suivante
            echo "bienvenue";
            exit();
        } else {
            $error = "Identifiants incorrects.";
        }

    } else {
        $error = "Merci de bien vouloir renseigner les champs";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="style.css">
    <style>
        
    </style>
</head>
<body>
    <header>
  <div class="logo">
    <img src="gghkjhk.PNG" alt="Logo" />
    <div>
      <strong></strong><br>
      <small></small>
    </div>
  </div>

  <div class="search-bar">
    <input type="text" placeholder="Chercher un livre, un auteur, un éditeur…">
    <button>+</button>
  </div>

  <div class="nav-buttons">
    <button class="btn-accueil">Accueil</button>
    <button class="btn-bibli">Bibliothèque</button>
    <button class="btn-panier">Panier <i class="fas fa-shopping-cart"></i></button>
    <button class="btn-login">Login <i class="fas fa-user"></i></button>
  </div>
</header>

    <div class="login-box">
        <form action="login.php" method="post">
            <input name="username" placeholder="nom d'utilisateur" value="">
            <input name="password" type="password" placeholder="mot de passe">
            <input name="login" type="submit" value="connexion" class="login">
            <input name="subscribe" type="submit" value="inscription" class="sub">
            
        </form>
        <p class="error"><?= $error ?></p>
    </div>
</body>
</html>
