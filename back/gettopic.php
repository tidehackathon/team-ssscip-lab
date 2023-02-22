<?php

// Зробити запит до ElasticSearch
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://10.0.201.201:9200/topics/_search?size=1000");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Перетворити відповідь в масив PHP
$data = json_decode($response, true);

// Отримати тільки title з результату і повернути у форматі JSON
$titles = array_map(function($hit) { return $hit['_source']['title']; }, $data['hits']['hits']);
echo json_encode(array('titles' => $titles));