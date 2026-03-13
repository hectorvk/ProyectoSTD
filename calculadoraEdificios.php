<?php
require("hasLoginProyectoStardew.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Calculadora de Edificios</title>

    <link rel="stylesheet" href="css/estilosProyectoStardew.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php require("header.php");//incluimos el header con el menu de navegación?>
    <div class="main-container mt-4">
        <a href="homeProyectoStardew.php" class="btn btn-secondary mb-3">Volver a Home</a>

        <div class="main-container">
            <div class="panel">

                <h3>Calculadora de Edificios</h3>

                <label for="edificio">Edificio (Base de Datos)</label>
                <select id="edificio">
                    <option value="">Cargando edificios...</option>
                </select>

                <label for="cantidad">Cantidad de edificios:</label>
                <input type="number" id="cantidad" min="1" value="1">

                <button id="btnCalcular">Calcular</button>

                <div id="resultados" class="mt-3"></div>
            </div>

            <a href="index.php" class="btn-back">Volver a Calculadoras</a>
        </div>

   
    </div>

    <script src="js/calculadoraEdificios.js"></script>
    <?php require("footer.php");//Incluimos el footer ?>
</body>

</html>
