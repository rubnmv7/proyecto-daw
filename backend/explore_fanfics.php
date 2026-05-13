<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

require_once __DIR__ . '/../conexion.php';

$buscar = trim($_GET['buscar'] ?? '');
$genero = (int) ($_GET['genero'] ?? 0);

$where = "WHERE f.estado = 'Terminado'";
$params = [];
$types = '';

if ($buscar !== '') {
    $where .= " AND (f.titulo LIKE ? OR f.descripcion LIKE ?)";
    $like = "%$buscar%";
    $params[] = $like;
    $params[] = $like;
    $types .= 'ss';
}

if ($genero > 0) {
    $where .= " AND EXISTS (SELECT 1 FROM tienen t2 WHERE t2.ID_fanfic = f.ID_fanfic AND t2.ID_genero = ?)";
    $params[] = $genero;
    $types .= 'i';
}

$sql = "SELECT f.ID_fanfic, f.titulo, f.descripcion, f.cantidad_capitulos, f.fecha_actualizacion,
               u.nombre_usuario as autor,
               GROUP_CONCAT(g.nombre_genero) as generos
        FROM fanfics f
        JOIN usuarios u ON u.ID_usuario = f.ID_usuario
        LEFT JOIN tienen t ON t.ID_fanfic = f.ID_fanfic
        LEFT JOIN generos g ON g.ID_genero = t.ID_genero
        $where
        GROUP BY f.ID_fanfic
        ORDER BY f.fecha_actualizacion DESC
        LIMIT 50";

$stmt = mysqli_prepare($conexion, $sql);
if ($params) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$fanfics = [];
while ($row = mysqli_fetch_assoc($result)) {
    $fanfics[] = [
        'id' => (int) $row['ID_fanfic'],
        'titulo' => $row['titulo'],
        'descripcion' => $row['descripcion'],
        'autor' => $row['autor'],
        'capitulos' => (int) $row['cantidad_capitulos'],
        'fecha' => $row['fecha_actualizacion'],
        'generos' => $row['generos'] ? explode(',', $row['generos']) : []
    ];
}

$sql_generos = "SELECT ID_genero, nombre_genero FROM generos ORDER BY nombre_genero";
$result_generos = mysqli_query($conexion, $sql_generos);
$generos_lista = [];
while ($g = mysqli_fetch_assoc($result_generos)) {
    $generos_lista[] = ['id' => (int) $g['ID_genero'], 'nombre' => $g['nombre_genero']];
}

echo json_encode([
    'fanfics' => $fanfics,
    'generos' => $generos_lista
], JSON_UNESCAPED_UNICODE);
