<?php
require('DBProyectoStardew.php');

if ($_SERVER["REQUEST_METHOD"] !== "POST") exit;

$nombreUsuario = trim($_POST['user'] ?? '');
$email = trim($_POST['email'] ?? '');
$nombre = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$genero = $_POST['genero'] ?? null;
$experiencia = $_POST['experiencia'] ?? null;
$claveEnClaro = $_POST['pass'] ?? '';

// Validación mínima — no usamos regex complejos porque el input viene de un form controlado
if (strlen($nombreUsuario) < 3 || strlen($claveEnClaro) < 6) {
    exit("Usuario mínimo 3 caracteres, contraseña mínimo 6 caracteres.");
}

// Verificamos duplicado ANTES de hashear — bcrypt es costoso y no tiene sentido calcularlo
// si el username ya existe en BD
$checkDuplicado = $conn->prepare("SELECT id FROM usuarios WHERE username = :user OR email = :email");//También evitamos emails duplicados
$checkDuplicado->bindParam(':user', $nombreUsuario);
$checkDuplicado->bindParam(':email', $email);
$checkDuplicado->execute();

if ($checkDuplicado->rowCount() > 0) {
    header("Location: registroProyectoStardew.php?status=existe");
    exit();
}

$claveHasheada = password_hash($claveEnClaro, PASSWORD_DEFAULT);
$rolPorDefecto = 'normal'; // No existe vía pública para crear admins — solo por BD directa

$insertUsuario = $conn->prepare("INSERT INTO usuarios 
    (username, email, nombre, apellido, genero, experiencia, password, rol) 
    VALUES 
    (:user, :email, :nombre, :apellido, :genero, :experiencia, :pass, :rol)");
$insertUsuario->bindParam(':user', $nombreUsuario);
$insertUsuario->bindParam(':email', $email);
$insertUsuario->bindParam(':nombre', $nombre);
$insertUsuario->bindParam(':apellido', $apellido);
$insertUsuario->bindParam(':genero', $genero);
$insertUsuario->bindParam(':experiencia', $experiencia);
$insertUsuario->bindParam(':pass', $claveHasheada);
$insertUsuario->bindParam(':rol',  $rolPorDefecto);
$insertUsuario->execute();

header("Location: registroProyectoStardew.php?status=ok");
exit();
?>
