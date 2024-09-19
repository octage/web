<?php
session_start();

// Verificar si el carrito existe
if (isset($_SESSION["cart"])) {
    // Obtener el ID del producto del formulario
    $id_producto = isset($_POST['id_producto']) ? (int)$_POST['id_producto'] : 0;

    // Verificar si el ID del producto es válido
    if ($id_producto > 0) {
        // Eliminar el producto del carrito si existe
        if (isset($_SESSION["cart"][$id_producto])) {
            unset($_SESSION["cart"][$id_producto]);
        }
    }
}

// Redirigir a la página anterior
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
