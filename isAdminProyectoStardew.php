<?php
session_start();
if($_SESSION["rol"] != "admin")
{
    echo "No tienes permisos para acceder aquí.";
    header("Location: loginProyectoStardew.php");
}
?>