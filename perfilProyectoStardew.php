<?php
require("hasLoginProyectoStardew.php");
require("DBProyectoStardew.php");

// Verificamos que el usuario esté logueado
if (!isset($_SESSION["user_id"])) {
    header("Location: loginProyectoStardew.php");
    exit();
}

// Consulta segura para obtener datos del usuario
$stmt = $conn->prepare("SELECT username, nombre, apellido, genero, experiencia, fecha_registro, rol FROM usuarios WHERE id = :id");
$stmt->bindParam(":id", $_SESSION["user_id"], PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Usuario no encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario - Proyecto Stardew</title>
    <link rel="stylesheet" href="css/estilosProyectoStardew.css">
    <script src="js/validaciones.js"></script>
</head>
<body>


    <div class="login-container">
        <h1>Perfil de Usuario</h1>

    <!--Mostramos los datos del usuario, readonly para los que solo se muestran y no se modifican-->
        <form id="perfilForm" class="crudForm" action="guardarPerfil.php" method="post">
            <label>Nombre de usuario</label>
            <input type="text" id="userName" value="<?php echo htmlspecialchars($user['username']); ?>">

            <label>Nombre</label>
            <input type="text" value="<?php echo htmlspecialchars($user['nombre']); ?>" readonly>

            <label>Apellido</label>
            <input type="text" value="<?php echo htmlspecialchars($user['apellido']); ?>" readonly>

            <label>Género</label>
            <input type="text" value="<?php echo htmlspecialchars($user['genero']); ?>" readonly>

            <label>Experiencia</label>
            <input type="text" value="<?php echo htmlspecialchars($user['experiencia']); ?>" readonly>

            <label>Fecha de registro</label>
            <!--Formateamos la fecha para que sea más legible-->
            <input type="text" value="<?php echo htmlspecialchars(date("d/m/Y", strtotime($user['fecha_registro']))); ?>" readonly>

            <label>Contraseña actual</label>
            <input type="password" id="currentPass" name="currentPass">

            <label>Nueva contraseña</label>
            <input type="password" id="newPass" name="newPass">

            <label>Confirmar nueva contraseña</label>
            <input type="password" id="confirmPass" name="confirmPass">

            <input type="submit" value="Actualizar perfil">
        </form>

        <a href="homeProyectoStardew.php" class="btn-back">Volver a Home</a>
    </div>
    
</body>
</html>