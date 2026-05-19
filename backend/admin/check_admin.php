<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'Admin') {
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

echo json_encode([
    'nombre' => $_SESSION['user']['nombre'],
    'email'  => $_SESSION['user']['email'],
    'foto'   => $_SESSION['user']['foto'] ?? null,
], JSON_UNESCAPED_UNICODE);
