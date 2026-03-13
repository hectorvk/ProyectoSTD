<?php
require('hasLoginProyectoStardew.php');
require('hasAdminProyectoStardew.php');
require('DBProyectoStardew.php');

if(!isset($_GET['id'])) die("Falta ID");

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM edificios WHERE id=:id");
$stmt->bindParam(':id',$id);
$stmt->execute();
$edificio = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$edificio) die("Edificio no encontrado");
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Editar Edificio</title>
        <link rel="stylesheet" href="css/estilosProyectoStardew.css">
        <script>
        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById("edificioForm");
            form.addEventListener("submit", e => {
                const nombre = document.getElementById("nombre").value.trim();
                if(nombre === "") {
                    alert("El nombre es obligatorio.");
                    e.preventDefault();
                }
            });
        });
        </script>
    </head>
    <body>
        <h1>Editar Edificio</h1>
        <form id="edificioForm" action="procesarEdificio.php" method="post">
            <input type="hidden" name="accion" value="editar">
            <input type="hidden" name="id" value="<?= $edificio['id'] ?>">

            <label>Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($edificio['nombre']) ?>">

            <label>Tiempo de Construcción (días)</label>
            <input type="number" name="tiempo_construccion" value="<?= $edificio['tiempo_construccion'] ?>" min="0">

            <label>Coste en Oro</label>
            <input type="number" name="coste_oro" value="<?= $edificio['coste_oro'] ?>" min="0">

            <label>Madera</label><input type="number" name="cant_madera" value="<?= $edificio['cant_madera'] ?>" min="0">
            <label>Piedra</label><input type="number" name="cant_piedra" value="<?= $edificio['cant_piedra'] ?>" min="0">
            <label>Madera Noble</label><input type="number" name="cant_madera_noble" value="<?= $edificio['cant_madera_noble'] ?>" min="0">
            <label>Fibra</label><input type="number" name="cant_fibra" value="<?= $edificio['cant_fibra'] ?>" min="0">
            <label>Arcilla</label><input type="number" name="cant_arcilla" value="<?= $edificio['cant_arcilla'] ?>" min="0">
            <label>Lingote Cobre</label><input type="number" name="cant_lingote_cobre" value="<?= $edificio['cant_lingote_cobre'] ?>" min="0">
            <label>Lingote Hierro</label><input type="number" name="cant_lingote_hierro" value="<?= $edificio['cant_lingote_hierro'] ?>" min="0">
            <label>Lingote Iridio</label><input type="number" name="cant_lingote_iridio" value="<?= $edificio['cant_lingote_iridio'] ?>" min="0">
            <label>Cuarzo Refinado</label><input type="number" name="cant_cuarzo_refinado" value="<?= $edificio['cant_cuarzo_refinado'] ?>" min="0">
            <label>Otros Materiales</label><input type="text" name="otros_materiales" value="<?= htmlspecialchars($edificio['otros_materiales']) ?>">

            <button type="submit">Guardar Cambios</button>
        </form>
        <a href="edificios.php">Volver a Edificios</a>
    </body>
</html>