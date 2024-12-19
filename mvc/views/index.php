<?php
// Fichier de gestion des produits
session_start();

// Initialiser la liste des produits si elle n'existe pas
if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = [];
}

// Traitement de l'ajout de produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['price'])) {
    $product = [
        'id' => count($_SESSION['products']) + 1,
        'name' => htmlspecialchars($_POST['name']),
        'price' => floatval($_POST['price']),
        'description' => htmlspecialchars($_POST['description'] ?? '')
    ];
    $_SESSION['products'][] = $product;
}

// Traitement de la suppression de produit
if (isset($_GET['delete'])) {
    $idToDelete = intval($_GET['delete']);
    $_SESSION['products'] = array_filter($_SESSION['products'], function($product) use ($idToDelete) {
        return $product['id'] !== $idToDelete;
    });
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion de Produits</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Gestion de Produits</h1>
    
    <form method="post">
        <input type="text" name="name" placeholder="Nom du produit" required>
        <input type="number" name="price" step="0.01" placeholder="Prix" required>
        <textarea name="description" placeholder="Description (optionnel)"></textarea>
        <button type="submit">Ajouter Produit</button>
    </form>

    <h2>Liste des Produits</h2>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prix</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['products'] as $product): ?>
                <tr>
                    <td><?= $product['name'] ?></td>
                    <td><?= number_format($product['price'], 2) ?> €</td>
                    <td><?= $product['description'] ?></td>
                    <td>
                        <a href="?delete=<?= $product['id'] ?>" class="delete" 
                           onclick="return confirm('Voulez-vous supprimer ce produit ?');">
                            Supprimer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
