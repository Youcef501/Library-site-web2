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
    <link rel="stylesheet" href="test.css">
    <style>
        
    </style>
</head>
<body>
    <div class="login-box">
        <form action="login.php" method="post">
            <input name="username" placeholder="nom d'utilisateur" value="<?php echo isset($username) ? htmlspecialchars($username) : '' ?>">
            <input name="password" type="password" placeholder="mot de passe">
            <input name="login" type="submit" value="connexion">
        </form>
        <p class="error"><?php echo $error; ?></p>
    </div>
</body>
</html>
