<?php
// ── Elimina un fanfic del usuario logueado ──
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
$fanficId = (int) ($data['id'] ?? 0);

if (!$fanficId) {
    http_response_code(400);
    echo json_encode(['error' => 'ID de fanfic no válido']);
    exit;
}

$userId = (int) $_SESSION['user']['id'];

// Verifica que el fanfic pertenezca al usuario
$stmt = mysqli_prepare($conexion, "SELECT ID_usuario FROM fanfics WHERE ID_fanfic = ?");
mysqli_stmt_bind_param($stmt, 'i', $fanficId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$fanfic = mysqli_fetch_assoc($result);

if (!$fanfic || (int) $fanfic['ID_usuario'] !== $userId) {
    http_response_code(403);
    echo json_encode(['error' => 'No tienes permiso para eliminar este fanfic']);
    exit;
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    mysqli_begin_transaction($conexion);

    mysqli_query($conexion, "DELETE FROM valoraciones WHERE ID_fanfic = $fanficId");
    mysqli_query($conexion, "DELETE FROM tienen WHERE ID_fanfic = $fanficId");
    mysqli_query($conexion, "DELETE FROM capitulos WHERE ID_fanfic = $fanficId");
    mysqli_query($conexion, "DELETE FROM fanfics WHERE ID_fanfic = $fanficId");

    mysqli_commit($conexion);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    mysqli_rollback($conexion);
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>