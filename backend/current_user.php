<?php
session_start();

if (isset($_SESSION['user'])) {
    echo json_encode([
        'nombre' => $_SESSION['user']['nombre'],
        'email' => $_SESSION['user']['email'],
        'foto' => $_SESSION['user']['foto'] ?? null,
        'tipo' => $_SESSION['user']['tipo'],
    ], JSON_UNESCAPED_UNICODE);
} else {
    echo 'no';
}