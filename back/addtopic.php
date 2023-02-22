<?php

$es_url = "http://10.0.201.201:9200";
$index_name = "topics";
$next_id_url = "{$es_url}/{$index_name}/_count";
$headers = array("Content-Type: application/json");

// Отримання наступного ID для дописування
$ch = curl_init($next_id_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
$response = curl_exec($ch);
curl_close($ch);

$next_id = json_decode($response)->count + 1; // Наступний ID

$url = "{$es_url}/{$index_name}/post/{$next_id}";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Обробка форми, якщо вона була надіслана
    $title = $_POST['title'];

    $data = array(
        "title" => $title,
        "user" => "vsb"
    );

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);

    curl_close($ch);

    echo $response;
}