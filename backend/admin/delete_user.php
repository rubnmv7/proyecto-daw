<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'Admin') {
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

include __DIR__ . '/../../conexion.php';

$userId = (int) ($_POST['id'] ?? 0);

if ($userId === 0) {
    echo json_encode(['error' => 'ID requerido']);
    exit;
}

if ($userId === (int) $_SESSION['user']['id']) {
    echo json_encode(['error' => 'No puedes eliminarte a ti mismo']);
    exit;
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    mysqli_begin_transaction($conexion);

    $fanficsRes = mysqli_query($conexion, "SELECT ID_fanfic FROM fanfics WHERE ID_usuario = $userId");
    $fanficIds = [];
    while ($row = mysqli_fetch_assoc($fanficsRes)) {
        $fanficIds[] = (int) $row['ID_fanfic'];
    }

    if ($fanficIds) {
        $ids = implode(',', $fanficIds);
        mysqli_query($conexion, "DELETE FROM valoraciones WHERE ID_fanfic IN ($ids)");
        mysqli_query($conexion, "DELETE FROM tienen WHERE ID_fanfic IN ($ids)");
        mysqli_query($conexion, "DELETE FROM capitulos WHERE ID_fanfic IN ($ids)");
    }

    mysqli_query($conexion, "DELETE FROM fanfics WHERE ID_usuario = $userId");
    mysqli_query($conexion, "DELETE FROM usuarios WHERE ID_usuario = $userId");

    mysqli_commit($conexion);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    mysqli_rollback($conexion);
    echo json_encode(['error' => 'Error al eliminar: ' . $e->getMessage()]);
}
