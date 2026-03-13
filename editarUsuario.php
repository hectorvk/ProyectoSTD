<?php
require("hasLoginProyectoStardew.php");
require("DBProyectoStardew.php");

$id = $_GET["id"] ?? null;
//Verificamos admin
$stmt = $conn->prepare("SELECT rol FROM usuarios WHERE id = :id");
$stmt->bindParam(":id", $_SESSION["user_id"]);
$stmt->execute();
$admin = $stmt->fetch(PDO::FETCH_ASSOC);
if($admin['rol'] !== 'admin'){ exit ("No eres admin");}

//Obtenemos usuario a editar
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = :id");
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$user) exit ("Usuario no encontrado");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar usuario</title>
        <link rel="stylesheet" href="css/estilosProyectoStardew.css">
    </head>
    <body>
        <div class="login-container">
            <h1>Editar Usuario</h1>

            <form action="actualizarUsuario.php" method="post">
                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

                <label>Usuario</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>">

                <label>Email</label>
                <input type="text" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">

                <label>Nombre</label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>">

                <label>Experiencia</label>
                <select name="experiencia">
                    <option value="nuevo" <?php if($user['experiencia']=="nuevo") echo "selected"; ?>>Nuevo</option>
                    <option value="veterano" <?php if($user['experiencia']=="veterano") echo "selected"; ?>>Veterano</option>
                </select>

                <?php if ($user['id'] != $_SESSION['user_id'])://admin no cambiará su rol?>
                <label>Rol</label>
                <select name="rol">
                    <option value="normal" <?php if($user['rol']=="normal") echo "selected"; ?>>Normal</option>
                    <option value="admin" <?php if($user['rol']=="admin") echo "selected"; ?>>Admin</option>
                </select>
                <?php else: ?>
                    <p>Rol actual: <?php echo htmlspecialchars($user['rol']); ?> (No se puede cambiar)</p>
                    <?php endif; ?>

                    <hr>
                    <label>Nueva contraseña</label>
                    <input type="password" name="newPass">

                    <label>Confirmar contraseña</label>
                    <input type="password" name="confirmPass">
                <br><br>

                <input type="submit" value="Guardar Cambios">

            </form>
        </div>
    </body>
</html>
