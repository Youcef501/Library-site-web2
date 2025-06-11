
<?php
session_start();
require 'config.php'; // Doit contenir $pdo = new PDO(...);

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
        // Vérifier si l'utilisateur existe déjà
        $stmt = $pdo->prepare("SELECT id FROM enregistrement WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = "Un compte existe déjà avec cet e-mail.";
        } else {
            // Hacher le mot de passe
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insérer dans la base de données
            $insert_stmt = $pdo->prepare("INSERT INTO enregistrement (email, password) VALUES (?, ?)");
            if ($insert_stmt->execute([$email, $hashed_password])) {
                // Rediriger vers la page de connexion
                header("Location: login.php?registered=1");
                exit();
            } else {
                $error = "Erreur lors de l'inscription. Veuillez réessayer.";
            }
        }
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
