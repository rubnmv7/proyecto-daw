<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../conexion.php';

$result = mysqli_query($conexion, "SELECT COUNT(*) as total FROM fanfics");
$total = (int) mysqli_fetch_assoc($result)['total'];

echo json_encode(['total' => $total]);
