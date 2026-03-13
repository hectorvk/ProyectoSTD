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
             ? ($_GET['status'] == "ok" ? "Usuario creado correctamente 🌱" : "El usuario o email ya están siendo utilizados 🌾") 
             : "";
    ?>
</div>

    <form id="registroForm" action="guardar_usuario.php" method="post">
        <label>Usuario</label>
        <input type="text" name="user" id="regUser">

        <label>Email</label>
        <input type="text" name="email" id="regEmail">

        <label>Nombre</label>
        <input type="text" name="nombre">

        <label>Apellido</label>
        <input type="text" name="apellido">

        <label>Contraseña</label>
        <input type="password" name="pass" id="regPass">

        <label>Género</label>

        <select name="genero">
            <option value="">Selecciona una opción</option>
            <option value="hombre">Hombre</option>
            <option value="mujer">Mujer</option>
            <option value="otro">Otro</option>
            <option value="prefiero_no_decirlo">Prefiero no decirlo</option>
        </select>

        <label>Experiencia en Stardew Valley</label>

        <input type="radio" name="experiencia" value="nuevo"> Nuevo agricultor
        <input type="radio" name="experiencia" value="veterano"> Veterano del valle

        <br><br>

        <input type="submit" value="Registrarse">
    </form>
    <script src="js/validaciones.js"></script>

    <div class="footer-text">
        🌱 Bienvenidx a tu nueva vida en el campo 🐓
    </div>
</div>

</body>
</html>