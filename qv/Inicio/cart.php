<?php
session_start();

// Verificar el contenido del carrito
$cartItems = isset($_SESSION["cart"]) ? $_SESSION["cart"] : [];

// Conectar a la base de datos
$link = mysqli_connect('localhost', 'root', '', 'qv') or die('Error con la conexión...');

// Obtener la información de los productos en el carrito
$products = [];
if (!empty($cartItems)) {
    $ids = implode(',', array_keys($cartItems)); // Obtener los IDs de los productos
    $query = "SELECT id_producto, Nombre_producto, Precio_unidad, Imagen FROM productos WHERE id_producto IN ($ids)";
    $resultado = mysqli_query($link, $query);
    
    while ($row = mysqli_fetch_assoc($resultado)) {
        $products[$row['id_producto']] = $row; // Almacenar información del producto
    }
}

// Calcular el total del carrito
$total = 0;
foreach ($cartItems as $id_producto => $quantity) {
    if (isset($products[$id_producto])) {
        $total += $products[$id_producto]['Precio_unidad'] * $quantity;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="astilos.css">
    <title>Carrito de Compras - Quiosco Virtual</title>
</head>
<body>

    <nav>
        <p class="logo-quiosco"><a href="./index.php">QUIOSCO VIRTUAL</a></p>
    </nav>

    <main>
        <h1>Carrito de Compras</h1>
        <div class="products">
            <?php if (!empty($cartItems)): ?>
                <?php foreach ($cartItems as $id_producto => $quantity): ?>
                    <?php if (isset($products[$id_producto])): ?>
                        <div class="product-card">
                            <img src="<?= '../img/imginicio/' . htmlspecialchars($products[$id_producto]['Imagen']) ?>" alt="<?= htmlspecialchars($products[$id_producto]['Nombre_producto']) ?>">
                            <h2><?= htmlspecialchars($products[$id_producto]['Nombre_producto']) ?></h2>
                            <p>Precio: $<?= number_format($products[$id_producto]['Precio_unidad'], 2) ?></p>
                            <p>Cantidad: <?= $quantity ?></p>
                            <p>Total: $<?= number_format($products[$id_producto]['Precio_unidad'] * $quantity, 2) ?></p>

                            <!-- Formulario para eliminar el producto -->
                            <form action="remove_from_cart.php" method="POST" style="margin-top: 10px;">
                                <input type="hidden" name="id_producto" value="<?= htmlspecialchars($id_producto) ?>">
                                <button type="submit" class="remove-button">Eliminar</button>
                            </form>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay productos en el carrito.</p>
            <?php endif; ?>
        </div>

        <h2 class="carttotal">Total del carrito: $<?= number_format($total, 2) ?></h2>
        <a class="volver" href="index.php">Volver a la tienda</a>
    </main>

</body>
</html>

<?php
// Cerrar la conexión a la base de datos
mysqli_close($link);
?>
