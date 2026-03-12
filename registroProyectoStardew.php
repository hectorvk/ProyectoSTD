<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Proyecto Stardew</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilosProyectoStardew.css">
</head>
<body>

<div class="login-container">
    <h1>Registro Proyecto Stardew</h1>

    <!--Mensajes de éxito o error -->
    <div class="footer-text">
    <?php
        echo isset($_GET['status']) 
             ? ($_GET['status'] == "ok" ? "Usuario creado correctamente 🌱" : "El usuario ya existe 🌾") 
             : "";
    ?>
</div>

    <form id="registroForm" action="guardar_usuario.php" method="post">
        <label>Usuario</label>
        <input type="text" name="user" id="regUser">

        <label>Contraseña</label>
        <input type="password" name="pass" id="regPass">

        <input type="submit" value="Registrarse">
    </form>
    <script src="js/validaciones.js"></script>

    <div class="footer-text">
        🌱 Bienvenido a tu nueva vida en el campo
    </div>
</div>

</body>
</html>