<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Pedidos</title>
</head>
<body>
<?php
$link = mysqli_connect('localhost', 'root', '', 'bd130624') or die('Error con la conexión... comuniquese con el admin');

$codpedido = $_REQUEST['codpedido'];
$cliente = $_REQUEST['cliente'];
$talle = $_REQUEST['talle'];
$cantidad = $_REQUEST['cantidad'];
$fecha=$_REQUEST['fecha'];
$boton = $_REQUEST['boton'];

if ($boton == "AGREGAR") {
    $orden = "INSERT INTO pedidos (cliente, talle, cantidad, fecha) VALUES ('$cliente', '$talle', '$cantidad', '$fecha')";
    mysqli_query($link, $orden) or die('Error al agregar: ' . mysqli_error($link));
    echo 'Agregado correctamente';
} elseif ($boton == "BORRAR") {
    $orden = "DELETE FROM pedidos WHERE codpedido = $codpedido";
    mysqli_query($link, $orden) or die("Error al borrar: " . mysqli_error($link));
    echo "Borrado correctamente";
} elseif ($boton == "MODIFICAR") {
    $orden = "UPDATE pedidos SET cliente='$cliente', talle='$talle', cantidad='$cantidad' WHERE codpedido = $codpedido";
    mysqli_query($link, $orden) or die("Error al modificar: " . mysqli_error($link));
    echo "Modificado correctamente";
} elseif ($boton == "BUSCAR") {
    $orden = "SELECT * FROM pedidos WHERE codpedido=$codpedido";
    $result = mysqli_query($link, $orden) or die("Error al buscar: " . mysqli_error($link));
    if (mysqli_num_rows($result) == 0) {
        echo "No se encontraron datos para ese código";
        $cliente = "";
        $codpedido = "";
        $talle="";
        $cantidad="";
        $fecha="";
    } else {
        $datos = mysqli_fetch_array($result);
        $cliente = $datos['cliente'];
        $codpedido = $datos['codpedido'];
        $talle = $datos['talle'];
        $cantidad = $datos['cantidad'];
        $fecha= $datos['fecha'];

    }
} elseif ($boton == "->") {
    $orden = "SELECT * FROM pedidos WHERE codpedido > $codpedido LIMIT 1";
    $result = mysqli_query($link, $orden) or die("Error: " . mysqli_error($link));
    if (mysqli_num_rows($result) == 0) {
        echo "No hay más datos";
    } else {
        $datos = mysqli_fetch_array($result);
        $cliente = $datos['cliente'];
        $codpedido = $datos["codpedido"];
        $talle = $datos['talle'];
        $cantidad = $datos['cantidad'];
        $fecha= $datos['fecha'];
    }
} elseif ($boton == "<-") {
    $orden = "SELECT * FROM pedidos WHERE codpedido < $codpedido ORDER BY codpedido DESC LIMIT 1";
    $result = mysqli_query($link, $orden) or die("Error: " . mysqli_error($link));
    if (mysqli_num_rows($result) == 0) {
        echo "No hay más datos";
    } else {
        $datos = mysqli_fetch_array($result);
        $cliente = $datos['cliente'];
        $codpedido = $datos["codpedido"];
        $talle = $datos['talle'];
        $cantidad = $datos['cantidad'];
        $fecha= $datos['fecha'];
    }
}
?>
<form action="" method="post">
    <table align=center>
        <tr >
            <td>Código del pedido
                <br>
                <input size="30px" type="text" name="codpedido" value="<?php echo ($codpedido); ?>"/> 
            </td>
        </tr>
        <tr >
            <td>Nombre del clientee
                <br>
                <?php 
                $orden = "SELECT * FROM clientes";
                $buscaCliente = mysqli_query($link, $orden) or die("Error al buscar clientes: " . mysqli_error($link));
                ?>
                <select name="cliente">
                    <?php while ($datos = mysqli_fetch_array($buscaCliente)) { ?>
                        <option value="<?php echo ($datos["codcliente"]); ?>" <?php if ($datos["codcliente"] == $cliente) echo 'selected'; ?>>
                            <?php echo ($datos["nomcliente"]); ?>
                        </option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr >
            <td>Talle
                <br>
                <input size="30px" type="text" name="talle" value="<?php echo($talle); ?>"/> 
            </td>
        </tr>
        <tr >
            <td>Cantidad
                <br>
                <input size="30px" type="text" name="cantidad" value="<?php echo ($cantidad); ?>"/> 
            </td>
        </tr>
        <tr>
            <td>
                <input type="date" name="fecha" value="<?php echo ($fecha); ?>" />
            </td>

        </tr> 
        <tr >
            <td id="botones">
                <input type="submit" name="boton" value="AGREGAR">
                <input type="submit" name="boton" value="MODIFICAR">
                <input type="submit" name="boton" value="BORRAR">
                <input type="submit" name="boton" value="BUSCAR">
                <input type="submit" name="boton" value="<-">
                <input type="submit" name="boton" value="->">
            </td>
        </tr>
    </table>
</form>
<?php mysqli_close($link); ?>
</body>
</html>
