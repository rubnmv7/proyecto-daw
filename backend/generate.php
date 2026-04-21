<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

$env = parse_ini_file(dirname(__DIR__) . '/.env');
$apiKey = $env['GEMINI_API_KEY'] ?? ''; //Sale del .env, ocultado en el .gititnore para no enseñar mi clave de API
$model = $env['GEMINI_MODEL'];

if (!$apiKey) {
    http_response_code(500);
    echo json_encode(['error' => 'Falta GEMINI_API_KEY']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$prompt = $data['prompt'] ?? '';

if (!$prompt) {
    http_response_code(400);
    echo json_encode(['error' => 'Falta prompt']);
    exit;
}

$body = json_encode([
    'contents' => [
        [
            'parts' => [
                ['text' => $prompt]
            ]
        ]
    ]
], JSON_UNESCAPED_UNICODE);

$url = 'https://generativelanguage.googleapis.com/v1beta/models/' . $model . ':generateContent?key=' . $apiKey;
$options = [
    'http' => [
        'method'  => 'POST',
        'header'  => "Content-Type: application/json\r\n",
        'content' => $body,
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

echo $response;
