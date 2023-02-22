<?php

// Отримуємо поточну дату
$today = new DateTime('now');
$todayStr = $today->format('Y-m-d');

// Формуємо запит до ElasticSearch на отримання кількості документів за сьогодні
$query = json_encode([
    "query" => [
        "match" => [
            "time" => $todayStr
        ]
    ]
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://10.0.201.201:9200/blog/_count");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$response = curl_exec($ch);
curl_close($ch);

// Перетворюємо відповідь в масив PHP та виводимо кількість документів
$data = json_decode($response, true);
echo $data['count'];
?>
