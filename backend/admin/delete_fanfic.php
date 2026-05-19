<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'Admin') {
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

include __DIR__ . '/../../conexion.php';

$fanficId = (int) ($_POST['id'] ?? 0);

if ($fanficId === 0) {
    echo json_encode(['error' => 'ID requerido']);
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
    echo json_encode(['error' => 'Error al eliminar: ' . $e->getMessage()]);
}
