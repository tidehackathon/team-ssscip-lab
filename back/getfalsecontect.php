<?php

// Створити діапазон дат в форматі ISO 8601 для сьогоднішньої дати
$now = new DateTime('now', new DateTimeZone('UTC'));
$startDate = $now->format('Y-m-d') . 'T00:00:00Z';
$endDate = $now->format('Y-m-d\TH:i:s\Z');

// Скласти запит до ElasticSearch
$requestBody = json_encode([
    'query' => [
        'bool' => [
            'must' => [
                ['match' => ['contains_propaganda' => true]],
                ['range' => ['created_at' => ['gte' => $startDate, 'lte' => $endDate]]]
            ]
        ]
    ]
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://10.0.201.201:9200/blog/_count");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
$response = curl_exec($ch);
curl_close($ch);

// Перетворити відповідь в масив PHP
$data = json_decode($response, true);

// Вивести загальну кількість твітів за сьогодні, де "Identify_false_context" : false
echo $data['count'];