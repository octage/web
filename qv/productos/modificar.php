<?php
session_start(); // Inicia la sesión

$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); 
}

// Conectar a la base de datos
$link = mysqli_connect('localhost', 'root', '', 'qv');
if (!$link) {
    die('Error de conexión: ' . mysqli_connect_error());
}

// Modificar producto
if (isset($_POST['modificar'])) {
    $id_producto = $_POST['id_producto'];
    $Nombre_producto = $_POST['Nombre_producto'];
    $Stock = $_POST['Stock'];
    $Precio_unidad = $_POST['Precio_unidad'];
    $Categoria = $_POST['Categoria'];

    if (isset($_FILES['Imagen']) && $_FILES['Imagen']['error'] === 0) {
        $imagen_nombre = basename($_FILES['Imagen']['name']);
        $imagen_tmp = $_FILES['Imagen']['tmp_name'];
        $imagen_ruta = '../img/imginicio/' . $imagen_nombre;

        if (!is_dir('../img/imginicio/')) {
            mkdir('../img/imginicio/', 0777, true);
        }

        if (move_uploaded_file($imagen_tmp, $imagen_ruta)) {
            $query = "UPDATE productos SET Nombre_producto='$Nombre_producto', Stock='$Stock', Precio_unidad='$Precio_unidad', Categoria='$Categoria', Imagen='$imagen_nombre' 
                      WHERE id_producto='$id_producto'";
            
            if (mysqli_query($link, $query)) {
                $_SESSION['message'] = 'Producto modificado correctamente';
            } else {
                $_SESSION['message'] = 'Error al modificar el producto: ' . mysqli_error($link);
            }
        } else {
            $_SESSION['message'] = 'Error al mover la imagen.';
        }
    } else {
        // Mantener la imagen actual
        $query = "UPDATE productos SET Nombre_producto='$Nombre_producto', Stock='$Stock', Precio_unidad='$Precio_unidad', Categoria='$Categoria' 
                  WHERE id_producto='$id_producto'";
        
        if (mysqli_query($link, $query)) {
            $_SESSION['message'] = 'Producto modificado correctamente';
        } else {
            $_SESSION['message'] = 'Error al modificar el producto: ' . mysqli_error($link);
        }
    }

    header("Location: ../Inicio/index.php");
    exit();
}

// Obtener la información del producto a modificar
if (isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];
    $query = "SELECT * FROM productos WHERE id_producto='$id_producto'";
    $result = mysqli_query($link, $query);
    $producto = mysqli_fetch_assoc($result);
}
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Inicio/astilos.css">
    <title>Modificar Producto</title>
</head>
<body>
<nav>
        <div class="logo-container">
            <p class="logo-quiosco"><a href="../Inicio/index.php">QUIOSCO VIRTUAL</a></p>
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
                <a href="../Inicio/cart.php">Carrito</a>
            </li>
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
        
        <form class="search-form" action="../Inicio/search.php" method="GET">
            <input type="text" name="query" placeholder="Buscar productos..." required>
            <button type="submit">Buscar</button>
        </form>
    </nav>
    <h1>Modificar Producto</h1>
    <form action="modificar.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <input type="hidden" name="id_producto" value="<?= htmlspecialchars($producto['id_producto']) ?>">
            <label for="Nombre_producto">Nombre del Producto:</label>
            <input type="text" id="Nombre_producto" name="Nombre_producto" value="<?= htmlspecialchars($producto['Nombre_producto']) ?>" required>

            <label for="Precio_unidad">Precio por Unidad:</label>
            <input type="number" id="Precio_unidad" name="Precio_unidad" value="<?= htmlspecialchars($producto['Precio_unidad']) ?>" required>

            <label for="Stock">Stock:</label>
            <input type="number" id="Stock" name="Stock" value="<?= htmlspecialchars($producto['Stock']) ?>" required>

            <label for="Categoria">Categoría:</label>
            <select id="Categoria" name="Categoria" required>
                <option value="snacks" <?= $producto['Categoria'] === 'snacks' ? 'selected' : '' ?>>Snacks</option>
                <option value="bebidas" <?= $producto['Categoria'] === 'bebidas' ? 'selected' : '' ?>>Bebidas</option>
                <option value="productos_personales" <?= $producto['Categoria'] === 'productos_personales' ? 'selected' : '' ?>>Productos Personales</option>
            </select>

            <label for="Imagen">Imagen:</label>
            <input type="file" id="Imagen" name="Imagen">
            
            <button type="submit" name="modificar">Modificar Producto</button>
        </div>
    </form>
    <a href="../Inicio/index.php">Cancelar</a>
</body>
</html>
