<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'Admin') {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

include __DIR__ . '/../../conexion.php';

$search = trim($_GET['search'] ?? '');
$estado = $_GET['estado'] ?? '';

$where = "WHERE 1=1";
$params = [];
$types = '';

if ($search !== '') {
    $where .= " AND (f.titulo LIKE ? OR u.nombre_usuario LIKE ?)";
    $like = "%$search%";
    $params[] = $like;
    $params[] = $like;
    $types .= 'ss';
}

if ($estado !== '') {
    $where .= " AND f.estado = ?";
    $params[] = $estado;
    $types .= 's';
}

$sql = "SELECT f.ID_fanfic, f.titulo, f.descripcion, f.estado, f.cantidad_capitulos, f.fecha_actualizacion,
               u.nombre_usuario as autor, u.ID_usuario as autor_id,
               (SELECT COUNT(*) FROM valoraciones v WHERE v.ID_fanfic = f.ID_fanfic) as total_valoraciones
        FROM fanfics f
        JOIN usuarios u ON u.ID_usuario = f.ID_usuario
        $where
        ORDER BY f.fecha_actualizacion DESC
        LIMIT 100";

$stmt = mysqli_prepare($conexion, $sql);
if ($params) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$fanfics = [];
while ($row = mysqli_fetch_assoc($result)) {
    $fanfics[] = [
        'id'           => (int) $row['ID_fanfic'],
        'titulo'       => $row['titulo'],
        'descripcion'  => $row['descripcion'],
        'estado'       => $row['estado'],
        'capitulos'    => (int) $row['cantidad_capitulos'],
        'fecha'        => $row['fecha_actualizacion'],
        'autor'        => $row['autor'],
        'autor_id'     => (int) $row['autor_id'],
        'valoraciones' => (int) $row['total_valoraciones'],
    ];
}

echo json_encode($fanfics, JSON_UNESCAPED_UNICODE);
