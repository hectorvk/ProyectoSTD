<?php

$servidor   = getenv('DB_HOST') ?: 'localhost';
$usuario    = getenv('DB_USER') ?: 'root';
$password   = getenv('DB_PASS') ?: '';
$base_datos = getenv('DB_NAME') ?: 'proyectostardew';

// PlanetScale requiere SSL; en local se omite
$puerto = 3306;
if (strpos($servidor, 'psdb.cloud') !== false) {
    $conn = mysqli_init();
    mysqli_ssl_set($conn, NULL, NULL, '/etc/ssl/certs/ca-bundle.crt', NULL, NULL);
    mysqli_real_connect($conn, $servidor, $usuario, $password, $base_datos, $puerto, NULL, MYSQLI_CLIENT_SSL);
} else {
    $conn = new mysqli($servidor, $usuario, $password, $base_datos);
}

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>