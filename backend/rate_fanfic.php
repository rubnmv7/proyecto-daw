<?php
// ── Valorar un fanfic ──
// Recibe un ID de fanfic, tipo (Positiva/Negativa) y comentario opcional
header('Content-Type: application/json; charset=utf-8');

session_start();

// Solo usuarios logueados pueden valorar
if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autenticado']);
    exit;
}

require_once __DIR__ . '/../conexion.php';

$fanficId = (int) ($_POST['fanfic_id'] ?? 0);
$tipo = $_POST['tipo'] ?? '';
$comentario = trim($_POST['comentario'] ?? '');

if ($fanficId === 0) {
    http_response_code(400);
    echo json_encode(['error' => 'ID de fanfic requerido']);
    exit;
}

if (!in_array($tipo, ['Positiva', 'Negativa'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Tipo de valoración inválido']);
    exit;
}

$fecha = date('Y-m-d');

// Inserta la valoración en la base de datos
$sql = "INSERT INTO valoraciones (ID_fanfic, fecha_valoracion, comentario, tipo_valoracion) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, 'isss', $fanficId, $fecha, $comentario, $tipo);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['success' => true], JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Error al guardar valoración']);
}
