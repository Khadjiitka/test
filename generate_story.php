<?php
header('Content-Type: application/json');
// На время отладки можно оставить, но если вылетает ошибка HTML, 
// эти строки добавят текст ошибки ПЕРЕД json, что и ломает JS.
error_reporting(0);

require 'config.php'; // Подключаем ключ
// Получаем данные с запроса (можно передать имя персонажа и т.д.)
$characterName = $_POST['character_name'] ?? 'Hero';
// Ссылка на Gemini API
$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $GEMINI_API_KEY;

// Формируем запрос к API
$data = [
    "contents" => [
        [
            "parts" => [
                ["text" => "Create a Skyrim character backstory for a hero named $characterName. In English, brief, immersive."]
            ]
        ]
    ]
];

$options = [
    "http" => [
        "header" => "Content-Type: application/json\r\n",
        "method" => "POST",
        "content" => json_encode($data),
        "ignore_errors" => true // Позволяет прочитать текст ошибки от API
    ]
];

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

if ($result === FALSE) {
    echo json_encode(["text" => "Server Error"]);
    exit;
}

$json = json_decode($result, true);

// Путь к тексту в ответе Gemini 1.5
$generatedText = $json['candidates'][0]['content']['parts'][0]['text'] ?? "Could not forge a story...";

echo json_encode(["text" => $generatedText]);
/* 
Берёт имя персонажа из POST.
Отправляет запрос к Gemini API.
Получает сгенерированный текст.
Возвращает JSON с полем text. 

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1); 


// Подключаем ключ
require 'config.php';

// Получаем данные с запроса (можно передать имя персонажа и т.д.)
$characterName = $_POST['character_name'] ?? 'Hero';

// Ссылка на Gemini API
$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=" . $GEMINI_API_KEY;

// Формируем запрос к API
$data = [
    "prompt" => [
        [
            "content" => "Create a Skyrim character backstory for a hero named $characterName. Make it interesting, detailed, and in a few sentences."
        ]
    ],
    "temperature" => 0.7,
    "candidate_count" => 1
];

$options = [
    "http" => [
        "header" => "Content-Type: application/json\r\n",
        "method" => "POST",
        "content" => json_encode($data)
    ]
];

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

if ($result === FALSE) {
    echo json_encode(["text" => "Error generating story"]);
    exit;
}

$json = json_decode($result, true);
$generatedText = $json['candidates'][0]['content'] ?? "No story generated";

echo json_encode(["text" => $generatedText]);
*/
