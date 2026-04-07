<?php
include __DIR__ . '/../conexion.php';
session_start();

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    echo 'faltan_campos';
    exit;
}

$stmt = mysqli_prepare($conexion, "SELECT ID_usuario, email, `contraseña`, nombre_usuario, tipo_usuario FROM usuarios WHERE email = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$usuario = mysqli_fetch_assoc($resultado);
mysqli_stmt_close($stmt);

if (!$usuario) {
    echo 'credenciales_incorrectas';
    exit;
}

if ($password !== $usuario['contraseña'] && !password_verify($password, $usuario['contraseña'])) {
    echo 'credenciales_incorrectas';
    exit;
}

$_SESSION['user'] = [
    'id' => $usuario['ID_usuario'],
    'email' => $usuario['email'],
    'nombre' => $usuario['nombre_usuario'],
    'tipo' => $usuario['tipo_usuario']
];

echo 'ok';
?>
