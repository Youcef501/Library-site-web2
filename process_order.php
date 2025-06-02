<?php
require 'config.php';


header('Content-Type: application/json');

try {
    // Récupération des données
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    

    // Validation basique
    if (empty($data['customer'])) {
        throw new Exception('Données client manquantes');
    }

    // Démarrer la transaction
    $pdo->beginTransaction();

    // 1. Créer la commande
    $stmt = $pdo->prepare("
        INSERT INTO orders (customer_name, customer_email, total_amount) 
        VALUES (:name, :email, :total)
    ");
    $stmt->execute([
        ':name' => $data['customer']['name'],
        ':email' => $data['customer']['email'],
        ':total' => $data['total']
    ]);
    $orderId = $pdo->lastInsertId();

    // 2. Ajouter les articles
    $stmt = $pdo->prepare("
        INSERT INTO order_items (order_id, book_id, quantity, unit_price)
        VALUES (:order_id, :book_id, :quantity, :price)
    ");

    foreach ($data['items'] as $item) {
        $stmt->execute([
            ':order_id' => $orderId,
            ':book_id' => $item['id'],
            ':quantity' => $item['quantity'],
            ':price' => $item['price']
        ]);
    }

    // Valider la transaction
    $pdo->commit();

    echo json_encode([
        'success' => true,
        'order_id' => $orderId
    ]);

} catch (Exception $e) {
    // Annuler en cas d'erreur
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    http_response_code(500);
    echo json_encode([
        'error' => $e->getMessage()
    ]);
}