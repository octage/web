<?php
session_start(); // Inicia la sesión

// Verificar si hay un mensaje en la sesión y guardarlo
$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Elimina el mensaje después de mostrarlo
}

if (isset($_POST['agregar'])) {
    // Obtener datos del formulario
    $Nombre_producto = $_POST['Nombre_producto'];
    $Stock = $_POST['Stock'];
    $Precio_unidad = $_POST['Precio_unidad'];
    $Categoria = $_POST['Categoria'];

    // Procesar la imagen
    if (isset($_FILES['Imagen']) && $_FILES['Imagen']['error'] === 0) {
        $imagen_nombre = basename($_FILES['Imagen']['name']);
        $imagen_tmp = $_FILES['Imagen']['tmp_name'];
        $imagen_ruta = '../img/imginicio/' . $imagen_nombre;

        // Crear directorio si no existe
        if (!is_dir('../img/imginicio/')) {
            mkdir('../img/imginicio/', 0777, true);
        }

        // Mover imagen a la carpeta
        if (move_uploaded_file($imagen_tmp, $imagen_ruta)) {
            // Conectar a la base de datos
            $link = mysqli_connect('localhost', 'root', '', 'qv') or die('Error con la conexión...');
            
            // Insertar datos en la base de datos
            $query = "INSERT INTO productos (Nombre_producto, Stock, Precio_unidad, Categoria, Imagen) 
                      VALUES ('$Nombre_producto', '$Stock', '$Precio_unidad', '$Categoria', '$imagen_nombre')";
            
            if (mysqli_query($link, $query)) {
                $_SESSION['message'] = 'Producto agregado correctamente';
            } else {
                $_SESSION['message'] = 'Error al agregar el producto: ' . mysqli_error($link);
            }
            mysqli_close($link);
        } else {
            $_SESSION['message'] = 'Error al mover la imagen.';
        }
    } else {
        $_SESSION['message'] = 'Error en la subida de la imagen: ' . $_FILES['Imagen']['error'];
    }

    // Redirigir a la misma página para mostrar el mensaje
    header('Location: agregar.php');
    exit();
}
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
    <style>
        .message {
            background-color: #d4edda; /* Color de fondo verde claro */
            color: #155724; /* Color del texto verde oscuro */
            border: 1px solid #c3e6cb; /* Borde verde claro */
            border-radius: 5px;
            padding: 1em;
            margin-bottom: 1em;
            text-align: center;
        }
    </style>
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
    
    <main>
        <div class="form-container">
            <h1 class="form-title">Agregar Producto</h1>
            
            <?php if ($message): ?>
                <div class="message">
                    <?= htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <form action="agregar.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="Nombre_producto">Nombre del Producto:</label>
                    <input type="text" id="Nombre_producto" name="Nombre_producto" required>
                </div>
                <div class="form-group">
                    <label for="Stock">Stock:</label>
                    <input type="number" id="Stock" name="Stock" required>
                </div>
                <div class="form-group">
                    <label for="Precio_unidad">Precio por Unidad:</label>
                    <input type="number" id="Precio_unidad" name="Precio_unidad" required>
                </div>
                <div class="form-group">
                    <label for="Categoria">Categoría:</label>
                    <select id="Categoria" name="Categoria" required>
                        <option value="snacks">Snacks</option>
                        <option value="bebidas">Bebidas</option>
                        <option value="productos_personales">Productos Personales</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Imagen">Imagen:</label>
                    <input type="file" id="Imagen" name="Imagen" required>
                </div>
                <button type="submit" name="agregar" class="submit-button">Agregar Producto</button>
            </form>
        </div>
    </main>
    
    <footer>
        &copy; 2024 Quiosco Virtual.
    </footer>
</body>
</html>

