<?php
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

        // DEPURACIÓN: Imprimir el nombre del archivo y la ruta destino
        echo 'Nombre del archivo: ' . $imagen_nombre . '<br>';
        echo 'Ruta destino: ' . $imagen_ruta . '<br>';

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
                echo 'Producto agregado correctamente';
            } else {
                echo 'Error al agregar el producto: ' . mysqli_error($link);
            }
            mysqli_close($link);
        } else {
            die('Error al mover la imagen.');
        }
    } else {
        // DEPURACIÓN: Imprimir el código de error si la subida falló
        echo 'Error en la subida de la imagen: ' . $_FILES['Imagen']['error'];
        die('Error en la subida del archivo.');
    }
}
?>
<?php
$folder = '../img/imginicio/';
if (is_writable($folder)) {
    echo 'La carpeta es escribible.';
} else {
    echo 'La carpeta no es escribible.';
}
?>
