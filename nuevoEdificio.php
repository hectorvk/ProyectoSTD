<?php
require('hasLoginProyectoStardew.php');
require('hasAdminProyectoStardew.php');
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Nuevo Edificio</title>
        <link rel="stylesheet" href="css/estilosProyectoStardew.css">
        <script src="js/validaciones.js"></script>
        <script>
        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById("edificioForm");
            form.addEventListener("submit", e => {
                const nombre = document.getElementById("nombre").value.trim();
                const coste = document.getElementById("coste_oro").value;
                const tiempo = document.getElementById("tiempo_construccion").value;
                if(nombre === "" || coste === "" || tiempo === "") {
                    alert("Nombre, coste y tiempo de construcción son obligatorios.");
                    e.preventDefault();
                }
            });
        });
        </script>
    </head>
    <body>
        <h1>Nuevo Edificio</h1>
        <form id="edificioForm" action="procesarEdificio.php" method="post">
            <input type="hidden" name="accion" value="crear">
            <label>Nombre</label>
            <input type="text" name="nombre" id="nombre">

            <label>Tiempo de Construcción (días)</label>
            <input type="number" name="tiempo_construccion" id="tiempo_construccion" min="0">

            <label>Coste en Oro</label>
            <input type="number" name="coste_oro" id="coste_oro" min="0">

            <label>Madera</label><input type="number" name="cant_madera" min="0" value="0">
            <label>Piedra</label><input type="number" name="cant_piedra" min="0" value="0">
            <label>Madera Noble</label><input type="number" name="cant_madera_noble" min="0" value="0">
            <label>Fibra</label><input type="number" name="cant_fibra" min="0" value="0">
            <label>Arcilla</label><input type="number" name="cant_arcilla" min="0" value="0">
            <label>Lingote Cobre</label><input type="number" name="cant_lingote_cobre" min="0" value="0">
            <label>Lingote Hierro</label><input type="number" name="cant_lingote_hierro" min="0" value="0">
            <label>Lingote Iridio</label><input type="number" name="cant_lingote_iridio" min="0" value="0">
            <label>Cuarzo Refinado</label><input type="number" name="cant_cuarzo_refinado" min="0" value="0">
            <label>Otros Materiales</label><input type="text" name="otros_materiales" value="">

            <button type="submit">Crear</button>
        </form>
        <a href="edificios.php">Volver a Edificios</a>
    </body>
</html>