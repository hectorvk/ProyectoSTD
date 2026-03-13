<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");
require 'conexion.php';

// Traemos las 9 columnas de materiales numéricas + otros_materiales (texto libre del admin)
// El JS filtra las que sean 0 para no contaminar el resultado con ruido visual
$consultaEdificios = "SELECT id, nombre, tiempo_construccion, coste_oro,
                      cant_madera, cant_piedra, cant_madera_noble, cant_fibra, cant_arcilla,
                      cant_lingote_cobre, cant_lingote_hierro, cant_lingote_iridio,
                      cant_cuarzo_refinado, otros_materiales
                      FROM edificios
                      ORDER BY nombre ASC";

$resultadoQuery = $conn->query($consultaEdificios);

if (!$resultadoQuery) {
    http_response_code(500);
    echo json_encode(['error' => 'Fallo en query de edificios — revisar schema BD']);
    exit;
}

$catalogoEdificios = [];
while ($filaEdificio = $resultadoQuery->fetch_assoc()) {
    $catalogoEdificios[] = $filaEdificio;
}

echo json_encode($catalogoEdificios);
$conn->close();
?>
