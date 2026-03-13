<?php
require('hasLoginProyectoStardew.php');
require('hasAdminProyectoStardew.php');
require('DBProyectoStardew.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') die("Método no permitido");

$accionSolicitada = $_POST['accion'] ?? '';

// Estas columnas van 1:1 con la tabla edificios en BD
// Si se añade una columna nueva, se añade aquí y el bind dinámico de abajo la recoge solo
$columnasBD = [
    'nombre', 'tiempo_construccion', 'coste_oro', 'cant_madera', 'cant_piedra',
    'cant_madera_noble', 'cant_fibra', 'cant_arcilla', 'cant_lingote_cobre',
    'cant_lingote_hierro', 'cant_lingote_iridio', 'cant_cuarzo_refinado', 'otros_materiales'
];

// null coalescing evita undefined index en campos opcionales del form
$payloadEdificio = [];
foreach ($columnasBD as $columna) {
    $payloadEdificio[$columna] = $_POST[$columna] ?? null;
}

if ($accionSolicitada === 'crear') {
    $listaColumnas = implode(',', $columnasBD);
    $listaParams   = ':' . implode(',:', $columnasBD);
    $stmt = $conn->prepare("INSERT INTO edificios ($listaColumnas) VALUES ($listaParams)");
    $stmt->execute($payloadEdificio);
    header("Location: edificios.php");
    exit();
}

if ($accionSolicitada === 'editar') {
    $idEdificioTarget = intval($_POST['id'] ?? 0);
    if (!$idEdificioTarget) die("ID de edificio inválido para la operación de edición.");

    // array_map con arrow function — más limpio que un foreach acumulador aquí
    $clausulasSet = array_map(fn($c) => "$c = :$c", $columnasBD);
    $stmt = $conn->prepare("UPDATE edificios SET " . implode(',', $clausulasSet) . " WHERE id = :id");
    $payloadEdificio['id'] = $idEdificioTarget;
    $stmt->execute($payloadEdificio);
    header("Location: edificios.php");
    exit();
}

die("Acción '$accionSolicitada' no reconocida por el procesador de edificios.");
?>
