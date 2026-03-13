<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Proyecto Stardew</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilosProyectoStardew.css">
</head>
<body>

    <div class="login-container">
        <h1> Proyecto Stardew </h1>

        <!--Formulario-->
        <form id="loginForm" action="comprobarLoginProyectoStardew.php" method="post">
            <!--Usuario-->
            <label>Usuario</label>
            <input type="text" name="user" id="loginUser">
            <!--Contraseña-->
            <label>Contraseña</label>
            <input type="password" name="pass" id="loginPass">

            <input type="submit" value="Entrar en la Granja">
        </form>

        <!-- Enlace al registro -->
        <div class="footer-text" style="margin-top:20px;">
            ¿No tienes cuenta?<br>
            <a href="registroProyectoStardew.php">🌱 Crear cuenta</a>
        </div>
        <!--Validación con JS -->
        <script src="js/validaciones.js"></script>

        <div class="footer-text">
            Bienvenido a tu nueva vida en el campo 🐓
        </div>
    </div>

</body>
</html>
