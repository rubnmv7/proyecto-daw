<?php
// ── Devuelve los datos del usuario logueado ──
// El frontend lo usa para saber si hay sesión activa y quién es
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