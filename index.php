<?php
require("hasLoginProyectoStardew.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stardew Valley - Planificador de Granja</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/estilosProyectoStardew.css">
</head>

<body>
    <div class="overlay"></div>
    <div class="container">
        <h1>Centro de Operaciones Rurales</h1>

        <div class="separator"></div>

        <div class="nav-grid">
            <a href="calculadoraCultivos.php" class="nav-card">
                <img src="src/calculadora cultivos.png" alt="Calculadora de Cultivos" class="card-image">
                <span>Calculadora de Cultivos</span>
            </a>

            <a href="calculadoraEdificios.php" class="nav-card">
                <img src="src/Calculadora edificios.png" alt="Calculadora de Edificios" class="card-image">
                <span>Calculadora de Edificios</span>
            </a>
        </div>

        <div class="separator"></div>

        <a href="homeProyectoStardew.php" class="btn-back">Volver a Home</a>


        <div class="footer">
            Creado por Hector y Gonzálo de DAM2V

        </div>
    </div>
</body>

</html>