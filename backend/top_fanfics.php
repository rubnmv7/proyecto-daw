<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../conexion.php';

$limit = $_GET['limit'] ?? 10;

$sql = "SELECT f.ID_fanfic, f.titulo, f.descripcion, f.estado, f.cantidad_capitulos,
               u.nombre_usuario AS autor,
               COUNT(v.ID_valoracion) AS total_val
        FROM fanfics f
        LEFT JOIN usuarios u ON f.ID_usuario = u.ID_usuario
        LEFT JOIN valoraciones v ON v.ID_fanfic = f.ID_fanfic
        GROUP BY f.ID_fanfic
        ORDER BY total_val DESC
        LIMIT $limit";

$res = mysqli_query($conexion, $sql);

$fanfics = [];
while ($row = mysqli_fetch_assoc($res)) {
    $fanfics[] = [
        'id'           => (int) $row['ID_fanfic'],
        'titulo'       => $row['titulo'],
        'descripcion'  => $row['descripcion'],
        'autor'        => $row['autor'],
        'estado'       => $row['estado'],
        'capitulos'    => (int) $row['cantidad_capitulos'],
        'valoraciones' => (int) $row['total_val'],
    ];
}

echo json_encode($fanfics, JSON_UNESCAPED_UNICODE);
