<?php
session_start();
require('hasLoginProyectoStardew.php');
require('DBProyectoStardew.php');

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT * FROM materiales ORDER BY nombre ASC");
    $materiales = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error en la base de datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materiales - Proyecto Stardew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilosProyectoStardew.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="homeProyectoStardew.php">Proyecto Stardew</a>
        <div class="navbar-nav">
            <a href="index.php">Calculadoras</a>
            <a href="personajesProyectoStardew.php">Vecinos</a>
            <a href="materialesProyectoStardew.php">Materiales</a>
            <a href="perfilProyectoStardew.php">Mi Perfil</a>
            <a href="logoutProyectoStardew.php">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="login-container">
    <h1>Materiales</h1>

    <table class="table-stardew">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fuente</th>
                <th>Precio de venta</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($materiales as $m): ?>
                <tr>
                    <td><?php echo htmlspecialchars($m['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($m['fuente'] ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($m['precio_venta']); ?>g</td>
                    <td><?php echo htmlspecialchars($m['descripcion'] ?? '-'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
