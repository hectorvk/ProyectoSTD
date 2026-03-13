<!--Archivo pensado para incluirse en páginas que requieren login y son privadas: require("hasLoginProyectoStardew.php")-->
<?php
// Inicia la sesión solo si no hay sesión activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica que el usuario esté logueado
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    header('Location: loginProyectoStardew.php');
    exit();
}
?>