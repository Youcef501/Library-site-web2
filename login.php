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


