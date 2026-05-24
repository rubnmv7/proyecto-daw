<?php
// ── Login de usuario ──
// Recibe email y contraseña, comprueba credenciales e inicia sesión
include __DIR__ . '/../conexion.php';
session_start();

// Coge los datos del formulario
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Si falta algún campo obligatorio
if (!$email || !$password) {
    echo 'faltan_campos';
    exit;
}

// Busca al usuario por email
$stmt = mysqli_prepare($conexion, "SELECT ID_usuario, email, `contraseña`, nombre_usuario, tipo_usuario, foto_perfil FROM usuarios WHERE email = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$usuario = mysqli_fetch_assoc($resultado);
mysqli_stmt_close($stmt);

// Si no existe el usuario
if (!$usuario) {
    echo 'credenciales_incorrectas';
    exit;
}

// Comprueba la contraseña
if ($password !== $usuario['contraseña'] && !password_verify($password, $usuario['contraseña'])) {
    echo 'credenciales_incorrectas';
    exit;
}

// Guarda los datos del usuario en la sesión
$_SESSION['user'] = [
    'id' => $usuario['ID_usuario'],
    'email' => $usuario['email'],
    'nombre' => $usuario['nombre_usuario'],
    'tipo' => $usuario['tipo_usuario'],
    'foto' => $usuario['foto_perfil']
];

echo 'ok';
?>
