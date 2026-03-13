<?php
require('DBProyectoStardew.php');

// $conn ya viene instanciado desde DBProyectoStardew — no re-creamos la conexión aquí
// Versiones anteriores duplicaban el PDO lo que generaba conflictos de charset en sesión
session_start();

$consultaUsuario = $conn->prepare("SELECT id, username, password, rol FROM usuarios WHERE username = :user");
$consultaUsuario->bindParam(':user', $_POST['user']);
$consultaUsuario->execute();

$filaUsuario = $consultaUsuario->fetch(PDO::FETCH_ASSOC);

// password_verify es timing-safe; nunca comparar hashes con === directamente
if ($filaUsuario && password_verify($_POST['pass'], $filaUsuario['password'])) {
    $_SESSION['logueado']  = true;
    $_SESSION['user_id']   = $filaUsuario['id'];
    $_SESSION['username']  = $filaUsuario['username'];
    $_SESSION['rol']       = $filaUsuario['rol'];
    header('Location: homeProyectoStardew.php');
} else {
    // No especificamos si falló usuario o contraseña — prevención de user enumeration
    header('Location: loginProyectoStardew.php');
}

$conn = null;
exit();
?>
