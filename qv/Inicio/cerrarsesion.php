<?php
session_start();
session_unset(); 
session_destroy(); 
header("Location: ./index.php");
$rol = $_SESSION['rol'];  
exit();
?>
