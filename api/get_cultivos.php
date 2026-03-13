<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");
require 'conexion.php';

// No incluimos rendimiento_por_cosecha — esa columna no existe aún en el schema
// El JS tiene un fallback a 1 para cuando se añada sin romper compatibilidad
$consultaCultivos = "SELECT id, nombre, precio_semilla, precio_venta, tiempo_crecimiento, tiempo_regreso
                     FROM cultivos
                     ORDER BY nombre ASC";

$resultadoQuery = $conn->query($consultaCultivos);

if (!$resultadoQuery) {
    // query() devuelve false casi siempre por error de schema, no de datos — revisar migraciones
    http_response_code(500);
    echo json_encode(['error' => 'Fallo en query de cultivos — revisar schema BD']);
    exit;
}

$listaCultivos = [];
while ($filaCultivo = $resultadoQuery->fetch_assoc()) {
    $listaCultivos[] = $filaCultivo;
}

echo json_encode($listaCultivos);
$conn->close();
?>
