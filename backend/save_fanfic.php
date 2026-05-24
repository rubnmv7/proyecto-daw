<?php
// ── Guardar fanfic en la BD ──
// Crea un fanfic nuevo con su primer capítulo y géneros asociados
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

session_start();

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autenticado']);
    exit;
}

require_once __DIR__ . '/../conexion.php';

$data = json_decode(file_get_contents('php://input'), true);

$titulo = trim($data['titulo'] ?? '');
$descripcion = trim($data['descripcion'] ?? '');
$estado = $data['estado'] ?? 'Borrador';
$generos = $data['generos'] ?? [];
$capitulo_titulo = trim($data['capitulo_titulo'] ?? 'Capítulo 1');
$capitulo_contenido = trim($data['capitulo_contenido'] ?? '');

if (empty($titulo)) {
    http_response_code(400);
    echo json_encode(['error' => 'El título es obligatorio']);
    exit;
}

if (!in_array($estado, ['Borrador', 'En progreso', 'Terminado'])) {
    $estado = 'Borrador';
}

$userId = (int) $_SESSION['user']['id'];
$fecha = date('Y-m-d');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Transacción: inserta fanfic, géneros y capítulo
try {
    mysqli_begin_transaction($conexion);

    $sql = "INSERT INTO fanfics (ID_usuario, titulo, descripcion, estado, cantidad_capitulos, fecha_actualizacion)
            VALUES (?, ?, ?, ?, 1, ?)";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 'issss', $userId, $titulo, $descripcion, $estado, $fecha);
    mysqli_stmt_execute($stmt);
    $fanficId = mysqli_insert_id($conexion);

    if ($fanficId === 0) {
        throw new Exception('No se pudo obtener el ID del fanfic.');
    }

    // Asocia los géneros seleccionados
    foreach ($generos as $generoId) {
        $generoId = (int) $generoId;
        $sql = "INSERT INTO tienen (ID_fanfic, ID_genero) VALUES (?, ?)";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, 'ii', $fanficId, $generoId);
        mysqli_stmt_execute($stmt);
    }

    // Inserta el primer capítulo
    if (!empty($capitulo_contenido)) {
        $longitud = mb_strlen($capitulo_contenido);
        $sql = "INSERT INTO capitulos (ID_fanfic, titulo, contenido, numero_capitulo, longitud)
                VALUES (?, ?, ?, 1, ?)";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, 'issi', $fanficId, $capitulo_titulo, $capitulo_contenido, $longitud);
        mysqli_stmt_execute($stmt);
    }

    mysqli_commit($conexion);

    echo json_encode(['success' => true, 'id' => $fanficId], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    mysqli_rollback($conexion);
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
