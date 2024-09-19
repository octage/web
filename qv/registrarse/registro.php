<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiosco Virtual - Registro</title>
    <link rel="stylesheet" href="../iniciarsesion/style.css">
    <link rel="icon" href="../img/logo.ico">
    <style>
        .hidden {
            display: none;
        }
        .message {
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
        .success {
            background-color: #4CAF50;
            color: white;
        }
        .error {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>
   
    <div class="formulario">
        
        <h1>Registro</h1>
        <form method="POST" action="">
            <div class="username">
                <input type="text" required name="Nombre" value="<?php echo isset($Nombre) ? htmlspecialchars($Nombre) : ''; ?>">
                <label>Nombre y apellido</label>
            </div>
            <div class="username">
                <input type="text" required name="DNI" value="<?php echo isset($DNI) ? htmlspecialchars($DNI) : ''; ?>">
                <label>DNI</label>
            </div>
            <div class="Curso">
                <select id="curso" name="Curso" required onchange="toggleOtroInput()">
                    <option value="" disabled selected>Seleccione un curso</option>
                    <option value="1ro 1ra CB" <?php echo (isset($Curso) && $Curso == '1ro 1ra CB') ? 'selected' : ''; ?>>primero c. básico</option>
                    <option value="curso2" <?php echo (isset($Curso) && $Curso == 'curso2') ? 'selected' : ''; ?>>segundo c. básico</option>
                    <option value="curso3" <?php echo (isset($Curso) && $Curso == 'curso3') ? 'selected' : ''; ?>>primero c. superior</option>
                    <option value="curso4" <?php echo (isset($Curso) && $Curso == 'curso4') ? 'selected' : ''; ?>>segundo c. superior</option>
                    <option value="Otro" <?php echo (isset($Curso) && $Curso == 'Otro') ? 'selected' : ''; ?>>tercero c. superior</option>
                    <option value="Otro" <?php echo (isset($Curso) && $Curso == 'Otro') ? 'selected' : ''; ?>>cuarto c. superior</option>
                </select>
            </div>

            <div class="username">
                <input type="password" required name="Contraseña" value="<?php echo isset($Contraseña) ? htmlspecialchars($Contraseña) : ''; ?>">
                <label>Contraseña</label>
            </div>
            <div class="username">
                <input type="password" required name="Con_rep" value="<?php echo isset($Con_rep) ? htmlspecialchars($Con_rep) : ''; ?>">
                <label>Repita la contraseña</label>
            </div>
            <input type="submit" name="boton" value="Registrarse">
            <div class="registrarse">
                ¿Ya tiene una cuenta? <a href="../iniciarsesion/iniciarsesion.php">Inicia sesión</a>
            </div>
        </form>

        <?php
$link = mysqli_connect('localhost', 'root', '', 'qv') or die('Error con la conexión... comuníquese con el admin');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $DNI = mysqli_real_escape_string($link, $_POST['DNI']);
    $Nombre = mysqli_real_escape_string($link, $_POST['Nombre']);
    $Curso = mysqli_real_escape_string($link, $_POST['Curso']);
    $Contraseña = mysqli_real_escape_string($link, $_POST['Contraseña']);
    $Con_rep = mysqli_real_escape_string($link, $_POST['Con_rep']);

    if ($Contraseña === $Con_rep) {
        if ($Curso == 'Otro') {
            $Curso = mysqli_real_escape_string($link, $_POST['OtroCurso']);
        }

        $query = "SELECT DNI FROM registro WHERE DNI = '$DNI'";
        $result = mysqli_query($link, $query);
        
        if (mysqli_num_rows($result) > 0) {
            echo '<div class="message error">El DNI ya está registrado. Inténtelo con otro.</div>';
        } else {
            $rol = 'cliente';
            $orden = "INSERT INTO registro (DNI, Nombre, Curso, Contraseña, Con_rep, rol) VALUES ('$DNI', '$Nombre', '$Curso', '$Contraseña', '$Con_rep', '$rol')";
            
            if (mysqli_query($link, $orden)) {
                echo '<div class="message success">Usuario registrado correctamente</div>';
            } else {
                echo '<div class="message error">Error al agregar: ' . mysqli_error($link) . '</div>';
            }
        }
    } else {
        echo '<div class="message error">Las contraseñas no coinciden. Inténtelo de nuevo.</div>';
    }
}
?>


    </div>

   
</body>
</html>
