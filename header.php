<?php
require("hasLoginProyectoStardew.php");
require("DBProyectoStardew.php");
require("lang.php");//Esto carga las traducciones
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto Stardew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilosProyectoStardew.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-success">
            <!-- Menú de navegación -->
            <a class="navbar-brand" href="homeProyectoStardew.php">Proyecto Stardew</a>
            <div class="colapse navbar-collapse justify-content-center">
                <div class="navbar-nav">
                    <a class="nav-link" href="index.php">Calculadoras</a>
                    <a class="nav-link" href="personajesProyectoStardew.php">Vecinos</a>
                    <a class="nav-link" href="materialesProyectoStardew.php">Materiales</a>
                    <a class="nav-link" href="tablonProyectoStardew.php">Tablón</a>
                    <a class="nav-link" href="perfilProyectoStardew.php">Mi Perfil</a>
                    <?php
                    // Mostrar Admin si se es
                    require_once("DBProyectoStardew.php");
                    $stmt = $conn->prepare("SELECT rol FROM usuarios WHERE id = :id");
                    $stmt->bindParam(":id", $_SESSION['user_id']);
                    $stmt->execute();
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($user['rol'] === 'admin'): ?>
                        <a class="nav-link text-warning" href="adminUsuarios.php">Admin</a>
                    <?php endif; ?>
                    <a class="nav-link" href="logoutProyectoStardew.php">Cerrar sesión</a>
                </div>
            </div>
    </nav>
    </header>
    <main>
