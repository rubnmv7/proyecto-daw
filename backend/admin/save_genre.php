<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'Admin') {
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

include __DIR__ . '/../../conexion.php';

$data = json_decode(file_get_contents('php://input'), true);
$id    = (int) ($data['id'] ?? 0);
$nombre = trim($data['nombre'] ?? '');

if (empty($nombre)) {
    echo json_encode(['error' => 'El nombre es obligatorio']);
    exit;
}

if ($id > 0) {
    $sql = "UPDATE generos SET nombre_genero = ? WHERE ID_genero = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 'si', $nombre, $id);
} else {
    $sql = "INSERT INTO generos (nombre_genero) VALUES (?)";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 's', $nombre);
}

if (mysqli_stmt_execute($stmt)) {
    echo json_encode([
        'success' => true,
        'id' => $id > 0 ? $id : mysqli_insert_id($conexion)
    ]);
} else {
    echo json_encode(['error' => 'Error al guardar el género']);
}
