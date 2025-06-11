<?php
include("config.php");

$nouveaux = $pdo->query("SELECT books.*, author.nom, author.prenom FROM books JOIN author ON books.author_id = author.id ORDER BY books.`date` DESC LIMIT 10 ")->fetchAll();
$derniere_chance = $pdo->query("SELECT books.*, author.nom, author.prenom FROM books JOIN author ON books.author_id = author.id ORDER BY books.stock DESC LIMIT 10")->fetchAll();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <meta charset="UTF-8">
  <title>ECE Bibliothèque</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
    <a href="accueil.html"><button class="btn-accueil">Accueil</button></a>
    <a href="bibliotheque.html"><button class="btn-bibli">Bibliothèque</button></a>
    <a href="Panier.html"><button class="btn-panier">Panier <i class="fas fa-shopping-cart"></i></button></a>
    <button class="btn-login">Login <i class="fas fa-user"></i></button>
  </div>
</header>





<body class="bg-light">

<div class="container py-4">
    <h1 class="text-center mb-4">Bibliothèque</h1>

    <h3>Nouveaux Livres</h3>
<div class="d-flex flex-row overflow-auto gap-3 mb-4">
    <?php foreach ($nouveaux as $book): ?>
        <div class="card" style="min-width: 200px;">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($book['title']) ?></h5>
                <p class="card-text">Auteur : <?= htmlspecialchars($book['nom']) ?> <?= htmlspecialchars($book['prenom']) ?></p>
                <p class="card-text"><small class="text-muted">Ajouté le <?= $book['date'] ?></small></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

    <hr class="my-5">

    <h3>Dernières chances</h3>
<div class="d-flex flex-row overflow-auto gap-3 mb-4">
    <?php foreach ($derniere_chance as $book): ?>
        <div class="card" style="min-width: 200px;">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($book['title']) ?></h5>
                <p class="card-text">Auteur : <?= htmlspecialchars($book['nom']) ?> <?= htmlspecialchars($book['prenom']) ?></p>
                <p class="card-text"><small class="text-muted">Ajouté le <?= $book['date'] ?></small></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>