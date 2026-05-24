<?php
// ── Lista de géneros disponibles ──
// Usado en el formulario de crear fanfic para seleccionar géneros
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

require_once __DIR__ . '/../conexion.php';

$sql = "SELECT ID_genero, nombre_genero FROM generos ORDER BY nombre_genero";
$result = mysqli_query($conexion, $sql);

$generos = [];
while ($row = mysqli_fetch_assoc($result)) {
    $generos[] = [
        'id' => (int) $row['ID_genero'],
        'nombre' => $row['nombre_genero']
    ];
}

echo json_encode($generos, JSON_UNESCAPED_UNICODE);