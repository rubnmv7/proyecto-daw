<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'Fanfia';

$conexion = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conexion) {
    http_response_code(500);
    echo 'Error de conexión: ' . mysqli_connect_error();
    exit;
}

mysqli_set_charset($conexion, 'utf8');

?>
