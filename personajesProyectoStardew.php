<?php
session_start();
require('hasLoginProyectoStardew.php'); // Verifica que el usuario esté logueado
require('DBProyectoStardew.php');

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener todos los personajes
    $stmt = $conn->query("SELECT * FROM personajes ORDER BY nombre ASC");
    $personajes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error en la base de datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vecinos - Proyecto Stardew</title>
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

<div class="personajes-container">
    <?php foreach($personajes as $p): ?>
        <div class="personaje">
            <img src="<?php echo $p['imagen_url']; ?>" alt="<?php echo $p['nombre']; ?>" width="120">
            <h3><?php echo htmlspecialchars($p['nombre']); ?></h3>
            <p><strong>Cumpleaños:</strong> <?php echo htmlspecialchars($p['temporada_cumpleanos']) . " " . htmlspecialchars($p['dia_cumpleanos']); ?></p>
            <?php if($p['es_soltero']): ?>
                <p>💖 Soltero(a)</p>
            <?php endif; ?>
            <p><strong>Regalos amados:</strong> <?php echo htmlspecialchars($p['regalos_amados']); ?></p>
            <p><strong>Regalos odiados:</strong> <?php echo htmlspecialchars($p['regalos_odiados']); ?></p>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>