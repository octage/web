<?php
session_start();

// Establecer el rol del usuario
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : 'invitado';

// Contar los productos en el carrito
$cartCount = isset($_SESSION["cart"]) ? array_sum($_SESSION["cart"]) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Inicio/astilos.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;500&display=swap" rel="stylesheet">
    <title>Quiosco Virtual</title>
    <link rel="icon" href="../img/logoqv.ico">
</head>
<body>

    <!-- Menú de navegación -->
    <nav>
        <div class="logo-container">
            <p class="logo-quiosco"><a href="../Inicio/index.php">QUIOSCO VIRTUAL</a></p>
            <?php if ($rol == 'vendedor'): ?>
                <p class="quiosquero-label">¡Bienvenido propietario!</p>
            <?php elseif ($rol == 'cliente'): ?>
                <p class="quiosquero-label">¡Bienvenido!</p>
            <?php endif; ?>
        </div>

        <ul class="cont-ul">
            <li class="develop"><a href="../Inicio/cart.php">Carrito (<?= $cartCount ?>)</a></li>
            <li class="develop">
                MI CUENTA
                <ul class="ul-second">
                    <?php if (isset($_SESSION['DNI'])): ?>
                        <li><a href="perfil.php">Mi Perfil</a></li>
                        <li><a href="../Inicio/cerrarsesion.php">Cerrar Sesión</a></li>
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

        <!-- Formulario de búsqueda -->
        <form class="search-form" action="search.php" method="GET">
            <input type="text" name="query" placeholder="Buscar productos..." required>
            <button type="submit">Buscar</button>
        </form>
    </nav>
    
    <!-- Contenido principal -->
    <main>
        <?php
$categoria = $_GET['categoria'];

// Conexión a la base de datos
$link = mysqli_connect('localhost', 'root', '', 'qv') or die('Error con la conexión...');

// Consulta SQL para obtener productos de la categoría
$query = "SELECT id_producto, Nombre_producto, Stock, Precio_unidad, Imagen FROM productos WHERE Categoria = '$categoria'";
$resultado = mysqli_query($link, $query);

$products = [];
if (mysqli_num_rows($resultado) > 0): ?>
    <div class='products'>
        <?php while ($row = mysqli_fetch_assoc($resultado)): 
            $imagen_ruta = '../img/imginicio/' . $row['Imagen']; ?>
            <div class='product-card'>
                <img src="<?= $imagen_ruta ?>" alt="<?= htmlspecialchars($row['Nombre_producto']) ?>">
                <h2><?= htmlspecialchars($row['Nombre_producto']) ?></h2>
                <p>Precio: $<?= number_format($row['Precio_unidad'], 2) ?></p>

                <?php if ($rol == 'vendedor'): ?>
                    <p>Unidades disponibles: <?= htmlspecialchars($row['Stock']) ?></p>
                <?php endif; ?>

                <div class='add-to-cart-container'>
                    <?php if ($rol == 'cliente'): ?>
                    <form action="../Inicio/add_to_cart.php" method="POST">
                        <input type="hidden" name="id_producto" value="<?= $row['id_producto'] ?>">
                        <button type="submit" name='agregar' class='add-to-cart-button'>Añadir al carrito</button>
                    </form>
                    <? endif ?>
                    <?php if ($rol == 'vendedor'): ?>
                    <form action="modificar.php" method="POST">
                        <input type="hidden" name="id_producto" value="<?= $row['id_producto'] ?>">
                        <button type="submit" class='add-to-cart-button'>modificar</button>
                    </form>
                    <? endif ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p>No hay productos en esta categoría.</p>
<?php endif;

// Cerrar la conexión a la base de datos
mysqli_close($link);
?>
    </main>
    <?php if (isset($_SESSION['add_to_cart_success'])): ?>
    <p class="success-message"><?= $_SESSION['add_to_cart_success']; ?></p>
    <?php unset($_SESSION['add_to_cart_success']); ?>
<?php endif; ?>

    <!-- Pie de página -->
    <footer>
        &copy; 2024 Quiosco Virtual.
    </footer>

</body>
</html>
