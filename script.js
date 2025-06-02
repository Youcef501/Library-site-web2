document.addEventListener('DOMContentLoaded', function() {
  // Éléments du DOM
  const emptyCartContainer = document.getElementById('empty-cart-container');
  const cartItemsContainer = document.getElementById('cart-items-container');
  const browseBtn = document.getElementById('browse-books');
  const qtyInputs = document.querySelectorAll('.qty-input');
  
  // Vérifier l'état du panier (simulé ici)
  const cartItems = getCartItems();
  
  // Afficher le bon container selon l'état du panier
  if (cartItems.length === 0) {
    emptyCartContainer.style.display = 'flex';
    cartItemsContainer.style.display = 'none';
  } else {
    emptyCartContainer.style.display = 'none';
    cartItemsContainer.style.display = 'block';
    setupCartFunctionality();
  }
  
  // Bouton "Parcourir la bibliothèque"
  browseBtn.addEventListener('click', function() {
    window.location.href = 'catalogue.html';
  });
  
  // Fonction pour simuler la récupération du panier
  function getCartItems() {
    // En pratique, vous utiliseriez localStorage ou une API
    // Pour l'exemple, nous simulons un panier vide ou non
    const showEmptyCart = false; // Changez à true pour tester le panier vide
    
    return showEmptyCart ? [] : [
      { id: 1, title: "MIST & MOUNTAINS", author: "Patrick Coulcher", price: 16.5, quantity: 1, image: "https://m.media-amazon.com/images/I/81RzvFq2A5L._SL1500_.jpg" },
      { id: 2, title: "Forest Journey", price: 15.5, quantity: 1, image: "https://m.media-amazon.com/images/I/91zvvzguL-L._SL1500_.jpg" }
    ];
  }
  
  // Fonction pour configurer les interactions du panier
  function setupCartFunctionality() {
    // Mise à jour du total lorsque la quantité change
    qtyInputs.forEach(input => {
      input.addEventListener('change', updateCartTotal);
    });
    
    // Bouton de commande
    document.querySelector('.checkout-btn').addEventListener('click', function() {
      alert('Commande passée avec succès!');
      // Ici vous voudrez probablement vider le panier
      localStorage.removeItem('cart');
      // Et afficher le panier vide
      emptyCartContainer.style.display = 'flex';
      cartItemsContainer.style.display = 'none';
    });
    
    // Calcul initial
    updateCartTotal();
  }
  
  // Fonction pour mettre à jour le total
  function updateCartTotal() {
    let totalItems = 0;
    let totalPrice = 0;
    
    document.querySelectorAll('.cart-item').forEach(item => {
      const price = parseFloat(item.getAttribute('data-price'));
      const quantity = parseInt(item.querySelector('.qty-input').value);
      
      totalItems += quantity;
      totalPrice += price * quantity;
    })
    
    document.getElementById('total-items').textContent = totalItems;
    document.getElementById('total-price').textContent = totalPrice.toFixed(2).replace('.', ',') + ' €';
  }
});
document.querySelector('.checkout-btn').addEventListener('click', function() {
    // Récupérer les articles du panier
    const items = Array.from(document.querySelectorAll('.cart-item')).map(item => ({
        id: parseInt(item.getAttribute('data-id')) || 1, // À remplacer par le vrai ID
        title: item.querySelector('h3').textContent,
        price: parseFloat(item.getAttribute('data-price')),
        quantity: parseInt(item.querySelector('.qty-input').value)
    }));

    // Calculer le total
    const total = items.reduce((sum, item) => sum + (item.price * item.quantity), 0);

    // Données client (à remplacer par un formulaire réel)
    const customer = {
        name: prompt("Votre nom complet :"),
        email: prompt("Votre email :")
    };

    // Envoyer la commande au serveur
    fetch('process_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            customer: customer,
            items: items,
            total: total
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(`Commande #${data.order_id} enregistrée !`);
            // Vider le panier
            localStorage.removeItem('cart');
            // Afficher le panier vide
            emptyCartContainer.style.display = 'flex';
            cartItemsContainer.style.display = 'none';
        } else {
            throw new Error(data.error || 'Erreur inconnue');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de la commande : ' + error.message);
    });
});
