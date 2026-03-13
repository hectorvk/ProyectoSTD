<?php
$servername = getenv('DB_HOST') ?: 'localhost';
$username   = getenv('DB_USER') ?: 'root';
$password   = getenv('DB_PASS') ?: '';
$dbname     = getenv('DB_NAME') ?: 'proyectostardew';

// PlanetScale requiere SSL; en local se omite
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
if (strpos($servername, 'psdb.cloud') !== false) {
    $options[PDO::MYSQL_ATTR_SSL_CA] = '/etc/ssl/certs/ca-bundle.crt';
    $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password, $options);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>