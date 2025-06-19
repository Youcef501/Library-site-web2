<?php
include("config.php"); // Ensure this path is correct and config.php sets up $pdo for database connection

// Fetch new books (recently added)
$nouveaux = $pdo->query("SELECT books.*, author.nom, author.prenom FROM books JOIN author ON books.author_id = author.id ORDER BY books.`date` DESC LIMIT 10")->fetchAll();

// Fetch last chance books (e.g., by lowest stock, adjust query as needed)
// Assuming 'stock' column exists in your 'books' table for "Dernières chances"
$derniere_chance = $pdo->query("SELECT books.*, author.nom, author.prenom FROM books JOIN author ON books.author_id = author.id ORDER BY books.stock ASC LIMIT 10")->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECE Bibliothèque</title>
    <link rel="stylesheet" href="style2.css">
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
    <a href="AjoutLivre.html"><button>+</button></a> </div>

  <div class="nav-buttons">
    <a href="accueil.html"><button class="btn-accueil">Accueil</button></a>
    <a href="library.php"><button class="btn-bibli">Bibliothèque</button></a>
    <a href="Panier.html"><button class="btn-panier">Panier <i class="fas fa-shopping-cart"></i> <span id="cart-count-header">(0)</span></button></a>
    <a href="login_static.html"><button class="btn-login">Login <i class="fas fa-user"></i></button></a>
  </div>
</header>

<div class="container py-4">
    <h1 class="text-center mb-4">Notre Bibliothèque</h1>

    <div class="library-section-container">
        <h3>Nouveaux Livres</h3>
        <div class="books-display-grid">
            <?php foreach ($nouveaux as $book):
                // Placeholder image as cover path is not in DB schema
                $coverImage = 'https://via.placeholder.com/150x200?text=Couverture';
                // If you add a 'cover_image_filename' column to your 'books' table and store the file name,
                // you would use something like:
                // if (!empty($book['cover_image_filename'])) {
                //     $coverImage = 'uploads/' . htmlspecialchars($book['cover_image_filename']);
                // }
            ?>
                <div class="book-card"
                     data-book-id="<?= htmlspecialchars($book['id']) ?>"
                     data-book-title="<?= htmlspecialchars($book['title']) ?>"
                     data-book-price="<?= htmlspecialchars($book['prix']) ?>">
                    <img src="<?= $coverImage ?>" alt="<?= htmlspecialchars($book['title']) ?> Cover">
                    <h4><?= htmlspecialchars($book['title']) ?></h4>
                    <p class="book-author"><?= htmlspecialchars($book['prenom']) ?> <?= htmlspecialchars($book['nom']) ?></p>
                    <p class="book-price"><?= number_format($book['prix'], 2, ',', '') ?> €</p>
                    <button class="add-to-cart-btn">Ajouter au panier</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <hr class="my-5">

    <div class="library-section-container">
        <h3>Dernières chances</h3>
        <div class="books-display-grid">
            <?php foreach ($derniere_chance as $book):
                $coverImage = 'https://via.placeholder.com/150x200?text=Couverture';
                // Same logic for cover image as above
            ?>
                <div class="book-card"
                     data-book-id="<?= htmlspecialchars($book['id']) ?>"
                     data-book-title="<?= htmlspecialchars($book['title']) ?>"
                     data-book-price="<?= htmlspecialchars($book['prix']) ?>">
                    <img src="<?= $coverImage ?>" alt="<?= htmlspecialchars($book['title']) ?> Cover">
                    <h4><?= htmlspecialchars($book['title']) ?></h4>
                    <p class="book-author"><?= htmlspecialchars($book['prenom']) ?> <?= htmlspecialchars($book['nom']) ?></p>
                    <p class="book-price"><?= number_format($book['prix'], 2, ',', '') ?> €</p>
                    <button class="add-to-cart-btn">Ajouter au panier</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Use cart-count-header for the main header's cart count
        const cartCountHeader = document.getElementById('cart-count-header');
        const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');

        // Initialize cart from localStorage or as an empty array
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Function to update cart count in header
        function updateCartCountDisplay() {
            // Calculate total quantity of items in the cart
            let totalQuantity = cart.reduce((sum, item) => sum + (item.quantity || 1), 0);
            cartCountHeader.textContent = `(${totalQuantity})`;
        }

        // Add event listeners to "Ajouter au panier" buttons
        addToCartButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                const bookCard = event.target.closest('.book-card');
                const bookId = bookCard.dataset.bookId;
                const bookTitle = bookCard.dataset.bookTitle;
                const bookPrice = parseFloat(bookCard.dataset.bookPrice);
                // Note: Image path is not available from DB, so not added to cart object here.
                // If you add a cover_image_filename column, you'd add: bookCard.dataset.bookImage;

                const existingItemIndex = cart.findIndex(item => item.id === bookId);

                if (existingItemIndex > -1) {
                    cart[existingItemIndex].quantity = (cart[existingItemIndex].quantity || 1) + 1;
                    alert(`Quantité de "${bookTitle}" mise à jour dans le panier.`);
                } else {
                    cart.push({ id: bookId, title: bookTitle, price: bookPrice, quantity: 1 });
                    alert(`"${bookTitle}" a été ajouté à votre panier !`);
                }

                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartCountDisplay(); // Update cart count in header
            });
        });

        // Initial update of cart count when page loads
        updateCartCountDisplay();
    });
</script>

</body>
</html>