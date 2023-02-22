<?php
// Зробити запит до ElasticSearch для отримання кількості документів
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://10.0.201.201:9200/blog/_count");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Перетворити відповідь в масив PHP
$data = json_decode($response, true);

// Вивести загальну кількість документів
echo $data['count'];
?>