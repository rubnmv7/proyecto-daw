<?php
// ─── Conexión a la base de datos ───
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'Fanfia';

$conexion = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conexion) {
    die('Error de conexión con la base de datos');
}

mysqli_set_charset($conexion, 'utf8mb4');