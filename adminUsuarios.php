<?php
require("hasLoginProyectoStardew.php");
require("DBProyectoStardew.php");

//Verificamos sesión
if(!isset($_SESSION["user_id"])){
    header("Location: loginProyectoStardew.php");
    exit();
}

//Obtenemos los datos del amidn logueado
$stmt = $conn->prepare("SELECT rol FROM usuarios WHERE id = :id");
$stmt->bindParam(":id", $_SESSION["user_id"]);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Solo los admins pueden entrar
if ($user["rol"] !== "admin") {
    echo "Acceso restringido, no eres un admin.";
    exit();
}

// Obtener todos los usuarios
$stmt = $conn->prepare("SELECT id, username, email, nombre, apellido, experiencia, fecha_registro, rol FROM usuarios");
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Panel Admin - Usuarios</title>
        <link rel="stylesheet" href="css/estilosProyectoStardew.css">
    </head>

    <body>

        <div class="login-container">

            <h1>Panel de Administración 🌾</h1>

            <table width="100%">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Nombre</th>
                    <th>Experiencia</th>
                    <th>Registro</th>
                    <th>Rol</th>
                    <th>Editar</th>
                    <th>Borrar</th>
                </tr>

                <?php foreach ($usuarios as $u): ?>
                <!--Traemos los datos y añadimos opciones de edición y borrado-->
                    <tr>
                        <td><?php echo $u['id']; ?></td>
                        <td><?php echo htmlspecialchars($u['username']); ?></td>
                        <td><?php echo htmlspecialchars($u['email']); ?></td>
                        <td><?php echo htmlspecialchars($u['nombre']); ?> <?php echo htmlspecialchars($u['apellido']); ?></td>
                        <td><?php echo htmlspecialchars($u['experiencia']); ?></td>
                        <td><?php echo date("d/m/Y", strtotime($u['fecha_registro'])); ?></td>
                        <td><?php echo htmlspecialchars($u['rol']); ?></td>
                        <td><a href="editarUsuario.php?id=<?php echo $u['id']; ?>">✏️</a></td>
                        <td>
                            <?php if ($u['id'] != $_SESSION['user_id']): //Evitamos que pueda borrarse a sí mismo?>
                                <a href="borrarUsuario.php?id=<?php echo $u['id']; ?>"
                                onclick="return confirm('¿Seguro que quieres borrar este usuario?');">🗑</a>
                            <?php else: ?>
                                <span title="No puedes borrarte a ti mismo">---</span><!--No puede borrarse a sí mismo-->
                            <?php endif; ?>

                        </td>
                    </tr>

                <?php endforeach; ?>

            </table>

            <br>

            <a href="homeProyectoStardew.php" class="btn-back">Volver al menú</a>

        </div>

    </body>
</html>