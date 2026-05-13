<?php
include __DIR__ . '/../conexion.php';
session_start();

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$nombre = $_POST['nombre'] ?? '';

if (!$email || !$password || !$nombre) {
    echo 'faltan_campos';
    exit;
}

$stmt = mysqli_prepare($conexion, "SELECT ID_usuario FROM usuarios WHERE email = ? OR nombre_usuario = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "ss", $email, $nombre);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_fetch_assoc($resultado)) {
    echo 'ya_existe';
    exit;
}
mysqli_stmt_close($stmt);

$hash = password_hash($password, PASSWORD_DEFAULT);
$fecha = date('Y-m-d');

$stmt = mysqli_prepare($conexion, "INSERT INTO usuarios (email, `contraseña`, nombre_usuario, tipo_usuario, fecha_creacion) VALUES (?, ?, ?, 'Normal', ?)");
mysqli_stmt_bind_param($stmt, "ssss", $email, $hash, $nombre, $fecha);

if (mysqli_stmt_execute($stmt)) {
    $id = mysqli_insert_id($conexion);
    $_SESSION['user'] = [
        'id' => $id,
        'email' => $email,
        'nombre' => $nombre,
        'tipo' => 'Normal',
        'foto' => null
    ];
    echo 'ok';
} else {
    echo 'error';
}
mysqli_stmt_close($stmt);
