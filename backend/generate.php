<?php
// ── Generación de fanfic con IA (Gemini 2.5 Flash) ──
// Recibe un prompt del frontend y llama a la API de Gemini para generar texto narrativo
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

// Carga la clave de API de Gemini desde el .env
$env = parse_ini_file(dirname(__DIR__) . '/.env');
$apiKey = $env['GEMINI_API_KEY'] ?? '';
$model = $env['GEMINI_MODEL'];

if (!$apiKey) {
    http_response_code(500);
    echo json_encode(['error' => 'Falta GEMINI_API_KEY']);
    exit;
}

// Lee el prompt que mandó el frontend
$data = json_decode(file_get_contents('php://input'), true);
$prompt = $data['prompt'] ?? '';

if (!$prompt) {
    http_response_code(400);
    echo json_encode(['error' => 'Falta prompt']);
    exit;
}

// Prepara la llamada a la API de Gemini
$body = json_encode([
    'contents' => [
        [
            'parts' => [
                ['text' => $prompt]
            ]
        ]
    ]
]);

$url = "https://generativelanguage.googleapis.com/v1beta/models/$model:generateContent?key=$apiKey";

// Llama a la API usando cURL
$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS => $body,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200) {
    $errorBody = json_decode($response, true);
    $msg = $errorBody['error']['message'] ?? 'Error desconocido de Gemini';
    http_response_code(502);
    echo json_encode(['error' => 'Gemini: ' . $msg]);
    exit;
}

// Saca el texto de la respuesta de Gemini
$result = json_decode($response, true);
$text = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

echo json_encode(['text' => $text], JSON_UNESCAPED_UNICODE);
