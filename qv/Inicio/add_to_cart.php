<?php
session_start();

// Verificar si el carrito está creado, si no, inicializarlo
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

// Obtener el ID del producto del formulario
$id_producto = isset($_POST['id_producto']) ? (int)$_POST['id_producto'] : 0;

// Verificar si el ID del producto es válido
if ($id_producto > 0) {
    // Verificar si el producto ya está en el carrito
    if (isset($_SESSION["cart"][$id_producto])) {
        // Si ya está, aumentar la cantidad
        $_SESSION["cart"][$id_producto]++;
    } else {
        // Si no está, agregarlo con cantidad 1
        $_SESSION["cart"][$id_producto] = 1;
    }
}

// Redirigir a la página anterior
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
