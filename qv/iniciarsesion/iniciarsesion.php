<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiosco Virtual - Inicio de Sesión</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="../img/logo.ico">
    <style>
        .error {
            color: white;
            background-color: #f44336;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
            font-size: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="formulario">
        <h1>Inicio de sesión</h1>
        <form method="POST" action="">
            <div class="username">
                <input type="text" name="DNI" required>
                <label>DNI</label>
            </div>
            <div class="username">
                <input type="password" name="Contraseña" required>
                <label>Contraseña</label>
            </div>
            <div class="recordar">¿Olvidó su contraseña?</div>
            <input type="submit" name="login" value="Iniciar"> 
            
            <div class="registrarse">
                ¿No tienes una cuenta? <a href="../registrarse/registro.php">Regístrate</a>
            </div>
        </form>
        
        <?php
        session_start();
        $link = mysqli_connect('localhost', 'root', '', 'qv') or die('Error con la conexión... comuníquese con el admin');

        if (isset($_POST['login'])) {
            $DNI = $_POST['DNI'];
            $Contraseña = $_POST['Contraseña'];

            $DNI = mysqli_real_escape_string($link, $DNI);
            $Contraseña = mysqli_real_escape_string($link, $Contraseña);

            $query = "SELECT * FROM registro WHERE DNI='$DNI' AND Contraseña='$Contraseña'";
            $result = mysqli_query($link, $query);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['DNI'] = $DNI;
                $_SESSION['rol'] = $row['rol'];

                if ($row['rol'] == 'vendedor') {
                    header("Location: ../Inicio/Index.php");
                } else {
                    header("Location: ../Inicio/index.php");
                }
                exit();
            } else {
                echo '<div class="error">DNI o contraseña incorrectos</div>';
            }
        }
        ?>
    </div>
</body>
</html>




