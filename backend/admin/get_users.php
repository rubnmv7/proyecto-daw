<?php
// ── Lista de usuarios (admin) ──
// Devuelve todos los usuarios con opción de búsqueda por nombre o email
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'Admin') {
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

include __DIR__ . '/../../conexion.php';

$search = trim($_GET['search'] ?? '');

$sql = "SELECT ID_usuario, email, nombre_usuario, tipo_usuario, foto_perfil, fecha_creacion FROM usuarios";
$params = [];
$types = '';

if ($search !== '') {
    $sql .= " WHERE nombre_usuario LIKE ? OR email LIKE ?";
    $like = "%$search%";
    $params[] = $like;
    $params[] = $like;
    $types .= 'ss';
}

$sql .= " ORDER BY fecha_creacion DESC";

$stmt = mysqli_prepare($conexion, $sql);
if ($params) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = [
        'id'    => (int) $row['ID_usuario'],
        'email' => $row['email'],
        'nombre' => $row['nombre_usuario'],
        'tipo'  => $row['tipo_usuario'],
        'foto'  => $row['foto_perfil'],
        'fecha' => $row['fecha_creacion'],
    ];
}

echo json_encode($users, JSON_UNESCAPED_UNICODE);
