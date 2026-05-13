<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

session_start();

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autenticado']);
    exit;
}

require_once __DIR__ . '/../conexion.php';

$userId = (int) $_SESSION['user']['id'];

$sql = "SELECT f.ID_fanfic, f.titulo, f.descripcion, f.estado, f.cantidad_capitulos, f.fecha_actualizacion,
               GROUP_CONCAT(g.nombre_genero) as generos
        FROM fanfics f
        LEFT JOIN tienen t ON t.ID_fanfic = f.ID_fanfic
        LEFT JOIN generos g ON g.ID_genero = t.ID_genero
        WHERE f.ID_usuario = ?
        GROUP BY f.ID_fanfic
        ORDER BY f.fecha_actualizacion DESC";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, 'i', $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$fanfics = [];
while ($row = mysqli_fetch_assoc($result)) {
    $fanfics[] = [
        'id' => (int) $row['ID_fanfic'],
        'titulo' => $row['titulo'],
        'descripcion' => $row['descripcion'],
        'estado' => $row['estado'],
        'capitulos' => (int) $row['cantidad_capitulos'],
        'generos' => $row['generos'] ? explode(',', $row['generos']) : [],
        'fecha_actualizacion' => $row['fecha_actualizacion']
    ];
}

echo json_encode($fanfics, JSON_UNESCAPED_UNICODE);