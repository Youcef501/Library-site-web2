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

 
</header>

    <div class="login-box">
        <form action="accueil.html" method="post">
            <input name="username" placeholder="nom d'utilisateur" value="">
            <input name="password" type="password" placeholder="mot de passe">
            <input name="login" type="submit" value="connexion" class="login">
        </form>
        <form action="register.php" method="post">
            <input name="subscribe" type="submit" value="inscription" class="sub">
        </from>
        <p class="error"><?= $error ?></p>
    </div>
</body>
</html>
