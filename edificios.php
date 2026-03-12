<?php
require('hasLoginProyectoStardew.php');
require('hasAdminProyectoStardew.php'); // Solo admins

require('DBProyectoStardew.php');

// Obtener todos los edificios
$stmt = $conn->prepare("SELECT * FROM edificios ORDER BY nombre ASC");
$stmt->execute();
$edificios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>CRUD Edificios - Proyecto Stardew</title>
        <link rel="stylesheet" href="css/estilosProyectoStardew.css">
        <script>
        function confirmarBorrado(nombre, id) {
            if(confirm("¿Seguro que quieres eliminar el edificio: " + nombre + "?")) {
                window.location.href = "borrarEdificio.php?id=" + id;
            }
        }
        </script>
    </head>
    <body>
        <h1>Gestión de Edificios</h1>
        <a href="nuevoEdificio.php">+ Nuevo Edificio</a>
        <table class="table-stardew" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tiempo Construcción</th>
                    <th>Coste Oro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($edificios as $e): ?>
                <tr>
                    <td><?= htmlspecialchars($e['nombre']) ?></td>
                    <td><?= $e['tiempo_construccion'] ?> días</td>
                    <td><?= $e['coste_oro'] ?>G</td>
                    <td>
                        <a href="editarEdificio.php?id=<?= $e['id'] ?>">Editar</a> | 
                        <a href="javascript:void(0);" onclick="confirmarBorrado('<?= addslashes($e['nombre']) ?>', <?= $e['id'] ?>)">Borrar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <a href="homeProyectoStardew.php">Volver a Home</a>
    </body>
</html>