<?php
// ── Registro de nuevo usuario ──
// Recibe email, contraseña y nombre, comprueba duplicados y crea el usuario
include __DIR__ . '/../conexion.php';
session_start();

// Coge los datos del formulario de registro
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$nombre = $_POST['nombre'] ?? '';

// Si falta algún campo obligatorio
if (!$email || !$password || !$nombre) {
    echo 'faltan_campos';
    exit;
}

// Comprueba si ya existe ese email o nombre de usuario
$stmt = mysqli_prepare($conexion, "SELECT ID_usuario FROM usuarios WHERE email = ? OR nombre_usuario = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "ss", $email, $nombre);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_fetch_assoc($resultado)) {
    echo 'ya_existe';
    exit;
}
mysqli_stmt_close($stmt);

// Encripta la contraseña y crea el usuario
$hash = password_hash($password, PASSWORD_DEFAULT);
$fecha = date('Y-m-d');

$stmt = mysqli_prepare($conexion, "INSERT INTO usuarios (email, `contraseña`, nombre_usuario, tipo_usuario, fecha_creacion) VALUES (?, ?, ?, 'Normal', ?)");
mysqli_stmt_bind_param($stmt, "ssss", $email, $hash, $nombre, $fecha);

if (mysqli_stmt_execute($stmt)) {
    // Inicia sesión automáticamente después de registrarse
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
