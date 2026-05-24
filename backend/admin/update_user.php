<?php
// ── Editar un usuario (admin) ──
// Actualiza nombre, email y tipo de un usuario desde el panel admin
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'Admin') {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

include __DIR__ . '/../../conexion.php';

$data = json_decode(file_get_contents('php://input'), true);
$userId = (int) ($data['id'] ?? 0);

if ($userId === 0) {
    echo json_encode(['error' => 'ID requerido']);
    exit;
}

$nombre = trim($data['nombre'] ?? '');
$email  = trim($data['email'] ?? '');
$tipo   = $data['tipo'] ?? '';

if (empty($nombre) || empty($email)) {
    echo json_encode(['error' => 'Nombre y email obligatorios']);
    exit;
}

$sql = "UPDATE usuarios SET nombre_usuario = ?, email = ?, tipo_usuario = ? WHERE ID_usuario = ?";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, 'sssi', $nombre, $email, $tipo, $userId);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Error al actualizar']);
}
