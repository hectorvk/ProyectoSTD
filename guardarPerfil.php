<?php
session_start();
require('DBProyectoStardew.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;

$idSesionActual       = $_SESSION['user_id'];
$nuevoNombreUsuario   = trim($_POST['user']        ?? '');
$claveActualIngresada = $_POST['currentPass']      ?? '';
$claveNueva           = $_POST['newPass']          ?? '';
$claveNuevaConfirmada = $_POST['confirmPass']      ?? '';

// Solo traemos el hash — no necesitamos más columnas para validar la operación
$fetchHashActual = $conn->prepare("SELECT password FROM usuarios WHERE id = :id");
$fetchHashActual->bindParam(':id', $idSesionActual);
$fetchHashActual->execute();
$registroActual = $fetchHashActual->fetch(PDO::FETCH_ASSOC);

if (!$registroActual) {
    // Si llegamos aquí con sesión activa y sin registro, la sesión está corrupta o el usuario fue borrado
    die("Sesión inválida. Vuelve a iniciar sesión.");
}

if (!empty($claveNueva)) {
    if (!password_verify($claveActualIngresada, $registroActual['password'])) {
        die("La contraseña actual no es correcta.");
    }
    if ($claveNueva !== $claveNuevaConfirmada) {
        die("La nueva contraseña y la confirmación no coinciden.");
    }
    $hashNuevaClave = password_hash($claveNueva, PASSWORD_DEFAULT);
    $updatePerfil   = $conn->prepare("UPDATE usuarios SET username = :user, password = :pass WHERE id = :id");
    $updatePerfil->bindParam(':pass', $hashNuevaClave);
} else {
    // Sin cambio de clave: solo actualizamos username — no tocamos el hash por nada
    $updatePerfil = $conn->prepare("UPDATE usuarios SET username = :user WHERE id = :id");
}

$updatePerfil->bindParam(':user', $nuevoNombreUsuario);
$updatePerfil->bindParam(':id',   $idSesionActual);
$updatePerfil->execute();

header("Location: perfilProyectoStardew.php?status=ok");
exit();
?>
