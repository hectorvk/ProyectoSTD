<?php
require('hasLoginProyectoStardew.php');

if ($_SESSION['rol'] !== "admin") {
    echo "No tienes permisos para acceder aquí 🌾";
    exit();
}
?>
