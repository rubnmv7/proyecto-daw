<?php
// ── Obtener un fanfic completo ──
// Devuelve todos los datos de un fanfic: info, capítulos, valoraciones y comentarios
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

require_once __DIR__ . '/../conexion.php';

$fanficId = (int) ($_GET['id'] ?? 0);

if ($fanficId === 0) {
    http_response_code(400);
    echo json_encode(['error' => 'ID de fanfic requerido']);
    exit;
}

// Datos básicos del fanfic con géneros
$sql = "SELECT f.ID_fanfic, f.titulo, f.descripcion, f.estado, f.cantidad_capitulos, f.fecha_actualizacion,
               u.nombre_usuario as autor,
               GROUP_CONCAT(g.nombre_genero) as generos
        FROM fanfics f
        JOIN usuarios u ON u.ID_usuario = f.ID_usuario
        LEFT JOIN tienen t ON t.ID_fanfic = f.ID_fanfic
        LEFT JOIN generos g ON g.ID_genero = t.ID_genero
        WHERE f.ID_fanfic = ?
        GROUP BY f.ID_fanfic";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, 'i', $fanficId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $fanfic = [
        'id' => (int) $row['ID_fanfic'],
        'titulo' => $row['titulo'],
        'descripcion' => $row['descripcion'],
        'estado' => $row['estado'],
        'autor' => $row['autor'],
        'capitulos' => (int) $row['cantidad_capitulos'],
        'generos' => $row['generos'] ? explode(',', $row['generos']) : [],
        'fecha_actualizacion' => $row['fecha_actualizacion']
    ];

    // Capítulos del fanfic
    $sql = "SELECT ID_capitulo, titulo, numero_capitulo, longitud, contenido
            FROM capitulos
            WHERE ID_fanfic = ?
            ORDER BY numero_capitulo";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $fanficId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $fanfic['capitulos_lista'] = [];
    while ($cap = mysqli_fetch_assoc($result)) {
        $fanfic['capitulos_lista'][] = [
            'id' => (int) $cap['ID_capitulo'],
            'titulo' => $cap['titulo'],
            'numero' => (int) $cap['numero_capitulo'],
            'longitud' => (int) $cap['longitud'],
            'contenido' => $cap['contenido']
        ];
    }

    // Conteo de valoraciones positivas
    $sql = "SELECT COUNT(*) as total FROM valoraciones WHERE ID_fanfic = ? AND tipo_valoracion = 'Positiva'";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $fanficId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $fanfic['positivas'] = (int) mysqli_fetch_assoc($result)['total'];

    // Conteo de valoraciones negativas
    $sql = "SELECT COUNT(*) as total FROM valoraciones WHERE ID_fanfic = ? AND tipo_valoracion = 'Negativa'";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $fanficId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $fanfic['negativas'] = (int) mysqli_fetch_assoc($result)['total'];

    // Comentarios recientes
    $sql = "SELECT tipo_valoracion, comentario, fecha_valoracion FROM valoraciones WHERE ID_fanfic = ? AND comentario != '' ORDER BY fecha_valoracion DESC LIMIT 10";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $fanficId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $fanfic['comentarios'] = [];
    while ($c = mysqli_fetch_assoc($result)) {
        $fanfic['comentarios'][] = [
            'tipo' => $c['tipo_valoracion'],
            'comentario' => $c['comentario'],
            'fecha' => $c['fecha_valoracion']
        ];
    }

    echo json_encode($fanfic, JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Fanfic no encontrado']);
}
