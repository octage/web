<?php
session_start();
$query = isset($_GET['query']) ? $_GET['query'] : '';


$products = [
    1 => ["name" => "Coca Cola", "price" => 2500, "image" => "../img/imginicio/coca.jpg"],
    2 => ["name" => "Pebete", "price" => 350, "image" => "../img/imginicio/pebete.jpg"],
    3 => ["name" => "Oreos", "price" => 1150, "image" => "../img/imginicio/oreos.jpg"],
    4 => ["name" => "Alfajor", "price" => 350, "image" => "../img/imginicio/alfajor.jpg"],
    5 => ["name" => "Sprite", "price" => 2500, "image" => "../img/imginicio/sprite.jpg"],
    6 => ["name" => "Surtidas Bagley", "price" => 1600, "image" => "../img/imginicio/surtidas.png"],
    7 => ["name" => "Alfajor Oreo", "price" => 1100, "image" => "../img/imginicio/oreoalfajor.png"],
    8 => ["name" => "Serranas", "price" => 900, "image" => "../img/imginicio/serranas.png"],
    9 => ["name" => "Pepas Trio", "price" => 1600, "image" => "../img/imginicio/pepastrio.jpg"],
    10 => ["name" => "Pepsi", "price" => 2200, "image" => "../img/imginicio/pepsilata.jpg"],
    11 => ["name" => "Papas Lays", "price" => 2000, "image" => "../img/imginicio/lays.jpg"],
    12 => ["name" => "Saladix Calabresa", "price" => 1500, "image" => "../img/imginicio/saladixcalabresa.jpg"],
];

$searchResults = [];
if ($query) {
    foreach ($products as $id => $product) {
        if (stripos($product['name'], $query) !== false) {
            $searchResults[$id] = $product;
        }
    }
}

$cartCount = isset($_SESSION["cart"]) ? array_sum($_SESSION["cart"]) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Resultados de búsqueda - Quiosco Virtual</title>
</head>
<body>
    <nav>
        <p class="logo-quiosco">QUIOSCO VIRTUAL</p>
        <ul class="cont-ul">
            <li class="develop">
                <a href="cart.php">Carrito (<?= $cartCount ?>)</a>
            </li>
            <li class="develop">
                MI CUENTA
                <ul class="ul-second">
                    <li class="back"><a href="../iniciarsesion/iniciarsesion.php">INICIAR SESIÓN</a></li>
                    <li><a href="../registrarse/registro.php">REGISTRARSE</a></li>
                </ul>
            </li>
            <li class="develop">CATEGORIAS</li>
        </ul>
        <form class="search-form" action="search.php" method="GET">
            <input type="text" name="query" placeholder="Buscar productos..." required>
            <button type="submit">Buscar</button>
        </form>
    </nav>

    <main>
        <h1>Resultados de búsqueda para "<?= htmlspecialchars($query) ?>"</h1>
        <div class="products">
            <?php if (!empty($searchResults)): ?>
                <?php foreach ($searchResults as $id => $product): ?>
                    <div class="product-card">
                        <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                        <h2><?= $product['name'] ?></h2>
                        <p>$<?= $product['price'] ?></p>
                        <form action="add_to_cart.php" method="post">
                            <input type="hidden" name="product_id" value="<?= $id ?>">
                            <button type="submit">Añadir al carrito</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No se encontraron productos que coincidan con su búsqueda.</p>
            <?php endif; ?>
        </div>
        <a class= "volver" href="index.php">Volver a la tienda</a>
    </main>

    <footer>
        &copy; 2024 Quiosco Virtual.
    </footer>
</body>
</html>

