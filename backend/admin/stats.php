<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'Admin') {
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

include __DIR__ . '/../../conexion.php';

$totalUsers       = (int) mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as c FROM usuarios"))['c'];
$totalFanfics     = (int) mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as c FROM fanfics"))['c'];
$totalValoraciones = (int) mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as c FROM valoraciones"))['c'];
$totalCapitulos   = (int) mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as c FROM capitulos"))['c'];
$totalGeneros     = (int) mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as c FROM generos"))['c'];

$fanficsByEstado = [];
$res = mysqli_query($conexion, "SELECT estado, COUNT(*) as c FROM fanfics GROUP BY estado");
while ($row = mysqli_fetch_assoc($res)) {
    $fanficsByEstado[$row['estado']] = (int) $row['c'];
}

$usersByMonth = [];
$res = mysqli_query($conexion, "SELECT DATE_FORMAT(fecha_creacion, '%Y-%m') as mes, COUNT(*) as c FROM usuarios GROUP BY mes ORDER BY mes DESC LIMIT 6");
while ($row = mysqli_fetch_assoc($res)) {
    $usersByMonth[] = ['mes' => $row['mes'], 'total' => (int) $row['c']];
}
$usersByMonth = array_reverse($usersByMonth);

$topFanfics = [];
$res = mysqli_query($conexion, "SELECT f.ID_fanfic, f.titulo, u.nombre_usuario as autor, COUNT(v.ID_valoracion) as total_val
                                FROM fanfics f
                                JOIN usuarios u ON u.ID_usuario = f.ID_usuario
                                LEFT JOIN valoraciones v ON v.ID_fanfic = f.ID_fanfic
                                GROUP BY f.ID_fanfic
                                ORDER BY total_val DESC
                                LIMIT 5");
while ($row = mysqli_fetch_assoc($res)) {
    $topFanfics[] = [
        'id'    => (int) $row['ID_fanfic'],
        'titulo' => $row['titulo'],
        'autor'  => $row['autor'],
        'total'  => (int) $row['total_val']
    ];
}

echo json_encode([
    'total_users'        => $totalUsers,
    'total_fanfics'      => $totalFanfics,
    'total_valoraciones'  => $totalValoraciones,
    'total_capitulos'    => $totalCapitulos,
    'total_generos'      => $totalGeneros,
    'fanfics_by_estado'  => $fanficsByEstado,
    'users_by_month'     => $usersByMonth,
    'top_fanfics'        => $topFanfics,
], JSON_UNESCAPED_UNICODE);
