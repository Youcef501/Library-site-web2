<?php
session_start();
require 'config.php'; // doit contenir la connexion $conn à la base de données

$error = '';

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])) {
    // Sécuriser les données reçues
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Vérification des champs
    if (empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Adresse e-mail invalide.";
    } elseif ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifie si l'utilisateur existe déjà
        $stmt = $pdo->prepare("SELECT id FROM enregistrement WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Un compte existe déjà avec cet e-mail.";
        } else {
            // Hacher le mot de passe
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insérer dans la base de données
            $insert_stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $insert_stmt->bind_param("ss", $email, $hashed_password);
            if ($insert_stmt->execute()) {
                // Rediriger vers la page de connexion ou une autre page
                header("Location: login.php?registered=1");
                exit();
            } else {
                $error = "Erreur lors de l'inscription. Veuillez réessayer.";
            }
        }

        $stmt->close();
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
    <form action="" method="post">
        <input name="email" type="email" placeholder="Adresse e-mail" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        <input name="password" type="password" placeholder="Mot de passe">
        <input name="confirm_password" type="password" placeholder="Confirmer le mot de passe">
        <input name="register" type="submit" value="S'inscrire" class="login">
    </form>
    <?php if (!empty($error)) : ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
</div>
</body>
</html>
