<?php
$host = 'localhost';
$user = 'root';  // update if needed
$pass = '';      // update if needed
$db = 'library';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$titre = $_POST['titre'];
$nomPrenom = $_POST['nom_auteur'];
$editeur = $_POST['editeur']; // Not stored (no column for this)
$datePub = $_POST['date_pub'];
$prix = $_POST['prix_livre'];

// Handle image upload (optional, not stored in DB)
$cover = $_FILES['cover'];
$coverPath = 'uploads/';
if (!file_exists($coverPath)) {
    mkdir($coverPath, 0777, true);
}
$coverName = basename($cover['name']);
move_uploaded_file($cover['tmp_name'], $coverPath . $coverName);

// Split author name
$nom = '';
$prenom = '';
$parts = explode(' ', $nomPrenom);
if (count($parts) >= 2) {
    $prenom = $parts[0];
    $nom = $parts[1];
} else {
    echo "Erreur : le nom de l'auteur doit contenir prénom et nom.";
    exit;
}

// Find or insert author
$stmt = $conn->prepare("SELECT id FROM author WHERE nom = ? AND prenom = ?");
$stmt->bind_param("ss", $nom, $prenom);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $author_id = $result->fetch_assoc()['id'];
} else {
    $stmt = $conn->prepare("INSERT INTO author (nom, prenom) VALUES (?, ?)");
    $stmt->bind_param("ss", $nom, $prenom);
    $stmt->execute();
    $author_id = $stmt->insert_id;
}

// Insert into books table (no category, default stock = 10)
$stmt = $conn->prepare("INSERT INTO books (title, price, stock, date, id_category, author_id) VALUES (?, ?, 10, ?, NULL, ?)");
$stmt->bind_param("sdsi", $titre, $prix, $datePub, $author_id);

if ($stmt->execute()) {
    echo "✅ Livre ajouté avec succès !";
} else {
    echo "❌ Erreur: " . $stmt->error;
}

$conn->close();
?>