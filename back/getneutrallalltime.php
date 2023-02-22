<?php
// Отримати значення параметру "sentiment" з URL
$sentiment = $_GET['sentiment'];

// Скласти запит до ElasticSearch з використанням параметру "sentiment"
$requestBody = json_encode([
    'query' => [
        'bool' => [
            'must' => [
                ['match' => ['sentiment' => $sentiment]],
            ]
        ]
    ]
]);

// Виконати запит до ElasticSearch і отримати кількість документів
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

// Вивести загальну кількість документів з відповідним значенням "sentiment"
echo $data['count'];
