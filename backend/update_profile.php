<?php
// ── Actualizar perfil de usuario ──
// Modifica nombre, email y foto del usuario logueado
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

$nombre = trim($data['nombre'] ?? '');
$email = trim($data['email'] ?? '');
$foto = trim($data['foto'] ?? '');

if (empty($nombre) || empty($email)) {
    http_response_code(400);
    echo json_encode(['error' => 'Nombre y email son obligatorios']);
    exit;
}

$userId = (int) $_SESSION['user']['id'];

$sql = "UPDATE usuarios SET nombre_usuario = ?, email = ?, foto_perfil = ? WHERE ID_usuario = ?";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, 'sssi', $nombre, $email, $foto, $userId);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['user']['nombre'] = $nombre;
    $_SESSION['user']['email'] = $email;
    $_SESSION['user']['foto'] = $foto ?: null;
    echo json_encode(['success' => true], JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Error al actualizar']);
}
