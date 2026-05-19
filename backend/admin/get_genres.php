<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'Admin') {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

include __DIR__ . '/../../conexion.php';

$sql = "SELECT g.ID_genero, g.nombre_genero,
               (SELECT COUNT(*) FROM tienen t WHERE t.ID_genero = g.ID_genero) as total_fanfics
        FROM generos g
        ORDER BY g.nombre_genero";

$result = mysqli_query($conexion, $sql);

$genres = [];
while ($row = mysqli_fetch_assoc($result)) {
    $genres[] = [
        'id'            => (int) $row['ID_genero'],
        'nombre'        => $row['nombre_genero'],
        'total_fanfics' => (int) $row['total_fanfics'],
    ];
}

echo json_encode($genres, JSON_UNESCAPED_UNICODE);
