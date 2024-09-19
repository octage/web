<?php
session_start();
if (isset($_SESSION['rol'])) {
    $rol = $_SESSION['rol'];
} else {
    $rol = 'invitado'; 
}

// Conectar a la base de datos
$link = mysqli_connect('localhost', 'root', '', 'qv') or die('Error con la conexión...');

// Consultar productos
$query = "SELECT id_producto, Nombre_producto, Precio_unidad, Imagen FROM productos";
$resultado = mysqli_query($link, $query);

$products = [];
while ($row = mysqli_fetch_assoc($resultado)) {
    $products[$row['id_producto']] = [
        'name' => $row['Nombre_producto'],
        'price' => $row['Precio_unidad'],
        'image' => '../img/imginicio/' . $row['Imagen']
    ];
}

// Cerrar la conexión a la base de datos
mysqli_close($link);

$cartCount = isset($_SESSION["cart"]) ? array_sum($_SESSION["cart"]) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="astilos.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;500&display=swap" rel="stylesheet">
    <title>Quiosco Virtual</title>
    <link rel="icon" href="../img/logoqv.ico">
</head>
<body>
    <nav>
        <div class="logo-container">
            <p class="logo-quiosco"><a href="index.php">QUIOSCO VIRTUAL</a></p>
            <?php
            if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'vendedor') {
                echo '<p class="quiosquero-label">¡Bienvenido propietario!</p>';
            } elseif (isset($_SESSION['rol']) && $_SESSION['rol'] == 'cliente') {
                echo '<p class="quiosquero-label">¡Bienvenido!</p>';
            }
            ?>
        </div>
        <ul class="cont-ul">
            <li class="develop">
                <a href="cart.php">Carrito (<?= $cartCount ?>)</a>
            </li>
            <li class="develop">
                MI CUENTA
                <ul class="ul-second">
                    <?php if (isset($_SESSION['DNI'])): ?>
                        <li><a href="perfil.php">Mi Perfil</a></li>
                        <li><a href="cerrarsesion.php">Cerrar Sesión</a></li>
                    <?php else: ?>
                        <li><a href="../iniciarsesion/iniciarsesion.php">INICIAR SESIÓN</a></li>
                        <li><a href="../registrarse/registro.php">REGISTRARSE</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <li class="develop">
                CATEGORÍAS
                <ul class="ul-second">
                    <li><a href="../productos/categoria.php?categoria=snacks">Snacks</a></li>
                    <li><a href="../productos/categoria.php?categoria=bebidas">Bebidas</a></li>
                    <li><a href="../productos/categoria.php?categoria=productos_personales">Productos Personales</a></li>
                </ul>
            </li>
        </ul>
        <form class="search-form" action="search.php" method="GET">
            <input type="text" name="query" placeholder="Buscar productos..." required>
            <button type="submit">Buscar</button>
        </form>
    </nav>
    
    <main>
        <?php
        echo 'Todos los productos'
        ?>
      <?php if ($rol == 'vendedor'): ?>
    <div class="product-card add-product-card">
        <a href="../productos/agregar.php" class="add-product-button">
            <div class="product-image">
                <!-- Puedes usar un ícono de signo más aquí -->
                <img src="../img/mas.png" alt="Agregar producto">
            </div>
            <div class="product-details">
                <h2>Agregar un producto nuevo</h2>
            </div>
        </a>
    </div>
<?php endif; ?>

        <div class="products">
            <?php foreach ($products as $id_producto => $product): ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    <h2><?= htmlspecialchars($product['name']) ?></h2>
                    <p>$<?= number_format($product['price'], 2) ?></p>
                   
                    <?php if ($rol == 'cliente'): ?> 
    <form action="add_to_cart.php" method="post">
        <input type="hidden" name="id_producto" value="<?= htmlspecialchars($id_producto) ?>">
        <button type="submit">Añadir al carrito</button>
    </form>
<?php endif; ?>

<?php if ($rol == 'vendedor'): ?>
    <form action="../productos/modificar.php" method="post">
        <input type="hidden" name="id_producto" value="<?= htmlspecialchars($id_producto) ?>">
        <button type="submit">Modificar</button>
    </form>
<?php endif; ?>

                </div>
            <?php endforeach; ?>
        </div>
    </main>
    
    <footer>
        &copy; 2024 Quiosco Virtual.
    </footer>
</body>
</html>




