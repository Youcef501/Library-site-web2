<?php
session_start();

$error = "";
$success = "";

// Simulons une base de données très simple (à remplacer par une vraie BDD)
$_username = "admin@ece.com"; // utilisateur déjà existant (pour test)

if (isset($_POST["register"])) {
    extract($_POST);

    if (!empty($email) && !empty($password) && !empty($confirm_password)) {
        if ($password === $confirm_password) {
            if ($email !== $_username) { // simulate uniqueness check
                // Ici, on enregistrerait dans la BDD
                $hashedPassword = sha1($password); // Note : utilisez password_hash() en prod

                $_SESSION["user"] = $email;
                header("Location: index.php");
                exit();
            } else {
                $error = "Cet utilisateur existe déjà.";
            }
        } else {
            $error = "Les mots de passe ne correspondent pas.";
        }
    } else {
        $error = "Merci de remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="style.css">
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
    <form action="register.php" method="post">
        <input name="email" type="email" placeholder="Adresse e-mail" value="">
        <input name="password" type="password" placeholder="Mot de passe">
        <input name="confirm_password" type="password" placeholder="Confirmer le mot de passe">
        <input name="register" type="submit" value="S'inscrire" class="login">
    </form>
    <p class="error"><?= $error ?></p>
</div>
</body>
</html>
