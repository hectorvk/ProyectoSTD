<?php
require('hasLoginProyectoStardew.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home Proyecto Stardew</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilosProyectoStardew.css">

</head>
<body>

<!-- Menú de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="homeProyectoStardew.php">Proyecto Stardew</a>

        <div class="navbar-nav">
            <a href="index.php">Calculadoras</a>
            <a href="personajesProyectoStardew.php">Vecinos</a>
            <a href="materialesProyectoStardew.php">Materiales</a>
            <a href="tablonProyectoStardew.php">Tablón</a>
            <a href="perfilProyectoStardew.php">Mi Perfil</a>
            <a href="logoutProyectoStardew.php">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="login-container text-center">
    <h1>Bienvenido a Proyecto Stardew, <?php echo htmlspecialchars($_SESSION['username']); ?></h1><!--Bienvenida personalizada-->

    <?php if ($_SESSION['rol'] === "admin"): ?>
        <p class="text-warning">🌟 Eres ADMINISTRADOR</p>

    <!--Aquí el menú para administrador-->
    <div class="row mt-4">
        <div class="col-md-4 mb-2">
            <a href="edificios.php" class="btn btn-warning w-100">Gestión de Edificios</a>
        </div>
    </div>
    <?php endif; ?>
</div>

</body>
</html>