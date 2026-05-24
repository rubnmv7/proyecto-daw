<?php
// ── Eliminar un género (admin) ──
// Solo se puede eliminar si ningún fanfic lo está usando
session_start();
header('Content-Type: application/json; charset=utf-8');
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

$genreId = (int) ($_POST['id'] ?? 0);

if ($genreId === 0) {
    http_response_code(400);
    echo json_encode(['error' => 'ID requerido']);
    exit;
}

// Comprueba si algún fanfic usa este género
$check = mysqli_query($conexion, "SELECT COUNT(*) as cnt FROM tienen WHERE ID_genero = $genreId");
$count = (int) mysqli_fetch_assoc($check)['cnt'];

if ($count > 0) {
    http_response_code(400);
    echo json_encode(['error' => "No se puede eliminar: el género está en uso por $count fanfic(s)"]);
    exit;
}

mysqli_query($conexion, "DELETE FROM generos WHERE ID_genero = $genreId");

if (mysqli_affected_rows($conexion) > 0) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Género no encontrado']);
}
