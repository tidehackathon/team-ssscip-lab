<?php

// Скласти запит до ElasticSearch
$requestBody = json_encode([
    'query' => [
        'bool' => [
            'must' => [
                ['match' => ['contains_propaganda' => true]],
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

// Вивести загальну кількість документів, що містять термін "contains_propaganda"
echo $data['count'];
